<?php

declare(strict_types=1);

namespace App\Controller\Api\Webshop;

use App\Entity\Webshop\Product;
use App\Controller\Api\AbstractApiController;
use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/cart', name: 'api_cart_')]
class CartController extends AbstractApiController
{
    #[Route('/', name: 'get')]
    public function get(Request $request): Response
    {
        $session = $request->getSession();
        $cart = $session->get('cart', []);
        
        return $this->json($cart);
    }
    
    #[Route('/add/{product}', name: 'add')]
    public function add(Product $product, Request $request): Response
    {
        $session = $request->getSession();
        
        $cart = $session->get('cart', []);
        if ($product->getActualStockAmount() > 0) {
            if (!isset($cart[$product->getId()])){
                $cart[$product->getId()] = [
                    'name' => $product->getName(),
                    'num' => 0,
                    'price' => $product->getPrice(),
                    'sumPrice' => 0
                ];
            }
            if ($cart[$product->getId()]['num'] < $product->getActualStockAmount()) {
                $cart[$product->getId()]['num']++;
                $cart[$product->getId()]['sumPrice'] = $cart[$product->getId()]['num']*$cart[$product->getId()]['price'];
            }
        }
        $session->set('cart', $cart);
        
        return $this->json($cart);
    }
    
    #[Route('/remove/{product}', name: 'remove')]
    public function remove(Product $product, Request $request): Response
    {
        $session = $request->getSession();
        
        $cart = $session->get('cart', []);
        if (isset($cart[$product->getId()]) && $cart[$product->getId()]['num'] > 0){
            if ($cart[$product->getId()]['num'] > 1) {
                $cart[$product->getId()]['num']--;
                $cart[$product->getId()]['sumPrice'] = $cart[$product->getId()]['num']*$cart[$product->getId()]['price'];
            } else {
                unset($cart[$product->getId()]);
            }
        }
        $session->set('cart', $cart);
        
        return $this->json($cart);
    }
    
    #[Route('/clear', name: 'clear')]
    public function clear(Request $request): Response
    {
        $session = $request->getSession();
        $session->set('cart', []);
        
        return $this->json([]);
    }
}