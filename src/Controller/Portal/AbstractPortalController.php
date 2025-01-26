<?php

declare(strict_types=1);

namespace App\Controller\Portal;

use App\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\Classification\CategoryServiceInterface;


abstract class AbstractPortalController extends AbstractController
{
    public function __construct(
        protected CategoryServiceInterface $categoryService,
        EntityManagerInterface $entityManager,
    ) 
    {
        parent::__construct($entityManager);
    }
}
