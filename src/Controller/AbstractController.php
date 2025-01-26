<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController As SymfonyAbstractController;
use Doctrine\ORM\EntityManagerInterface;


abstract class AbstractController extends SymfonyAbstractController
{
    public function __construct(
        protected EntityManagerInterface $entityManager
    )
    {}
}
