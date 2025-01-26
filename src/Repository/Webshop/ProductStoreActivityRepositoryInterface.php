<?php

declare(strict_types=1);

namespace App\Repository\Webshop;

use App\Entity\Webshop\Product;

interface ProductStoreActivityRepositoryInterface
{
    public function hasProductInitAction(Product $product): bool;
}
