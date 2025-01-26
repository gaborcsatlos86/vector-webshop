<?php

declare(strict_types=1);

namespace App\Controller\Portal\Webshop;

use App\Enums\{OrderState, ProductStoreAction};
use App\Entity\User;
use App\Entity\Webshop\{Order, OrderItem, Product, ProductStoreActivity};
use App\Controller\Portal\AbstractPortalController;
use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Attribute\Route;


#[Route('/order', name: 'app_order_')]
class OrderController extends AbstractPortalController
{
    #[Route('/', name: 'init')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        $user = $this->getUser();
        $cart = $session->get('cart', []);
        
        if (empty($cart)) {
            return $this->redirect('/');
        }
        $sumPrice = 0;
        foreach ($cart as $cartItem) {
            $sumPrice += ($cartItem['num'] * $cartItem['price']);
        }
        return $this->render('portal/order/index.html.twig', [
            'categories' => $this->categoryService->getTree(),
            'user' => $user,
            'cart' => $cart,
            'sumPrice'  => $sumPrice
        ]);
    }
    
    #[Route('/close', name: 'close', methods: Request::METHOD_POST)]
    public function close(Request $request): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->redirectToRoute('app_login');
        }
        $session = $request->getSession();
        $cart = $session->get('cart', []);
        if (empty($cart) ) {
            return $this->redirect('/');
        }
        $this->entityManager->beginTransaction();
        
        $order = (new Order())
            ->setUser($user)
            ->setSumPrice(0)
            ->setState(OrderState::Created)
            ->setName($request->request->get('name'))
            ->setAddress($request->request->get('address'))
        ;
        $this->entityManager->persist($order);
        $sumPrice = 0;
        foreach ($cart as $productId => $cartItem) {
            $sumPrice += ($cartItem['num'] * $cartItem['price']);
            /** @var Product $product */
            $product = $this->entityManager->getRepository(Product::class)->find($productId);
            $orderItem = (new OrderItem())
                ->setProduct($product)
                ->setOrder($order)
                ->setName($cartItem['name'])
                ->setProductNumber($product->getProductNumber())
                ->setDescription($product->getDescription())
                ->setCategory($product->getCategory())
                ->setUnitPrice($cartItem['price'])
                ->setAmount($cartItem['num'])
                ->setSumPrice($cartItem['num'] * $cartItem['price'])
            ;
            $this->entityManager->persist($orderItem);
            if ($cartItem['num'] > $product->getActualStockAmount()) {
                $this->entityManager->rollback();
                $this->addFlash('notice', 'Készlet probléma');
                return $this->redirectToRoute('app_order_init');
            }
            $productStoreActivity = (new ProductStoreActivity())
                ->setProduct($product)
                ->setAction(ProductStoreAction::Remove)
                ->setAmount($cartItem['num'])
            ;
            $this->entityManager->persist($productStoreActivity);
        }
        $order->setSumPrice($sumPrice);
        $this->entityManager->persist($order);
        
        $this->entityManager->flush();
        $this->entityManager->commit();
        
        $session->set('cart', []);
        
        return $this->render('portal/order/close.html.twig', [
            'categories' => $this->categoryService->getTree(),
            'user' => $user,
        ]);
    }
}