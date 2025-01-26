<?php

declare(strict_types=1);

namespace App\Controller\Portal;


use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractPortalController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {
        $user = $this->getUser();
        return $this->render('portal/home/index.html.twig', [
            'categories' => $this->categoryService->getTree(),
            'user' => $user
        ]);
    }
}