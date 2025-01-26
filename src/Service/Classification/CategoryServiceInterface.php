<?php

declare(strict_types=1);

namespace App\Service\Classification;

interface CategoryServiceInterface
{
    public function getTree(): array;
}