<?php

declare(strict_types=1);

namespace App\Controller\Portal\Webshop;

use App\Entity\Classification\Category;
use App\Entity\Webshop\Product;
use App\Controller\Portal\AbstractPortalController;
use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Attribute\Route;


#[Route('/category', name: 'app_category_')]
class CategoryController extends AbstractPortalController
{
    #[Route('/{category}', name: 'view')]
    public function index(Category $category, Request $request): Response
    {
        $user = $this->getUser();
        $products = $this->entityManager->getRepository(Product::class)->findBy(['category' => $category]);
        return $this->render('portal/category/index.html.twig', [
            'actualCategory' => $category,
            'products' => $products,
            'categories' => $this->categoryService->getTree(),
            'user' => $user
        ]);
    }
}