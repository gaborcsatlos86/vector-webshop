<?php

namespace App\DataFixtures;


use App\Entity\Classification\{Category, Context};
use App\Entity\Webshop\{Product, ProductStoreActivity};
use App\Enums\ProductStoreAction;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    
    
    public function load(ObjectManager $manager): void
    {
        $defaultContext = new Context();
        $defaultContext->setId('default');
        $defaultContext->setName('default');
        $defaultContext->setEnabled(true);
        
        $manager->persist($defaultContext);
        
        $mainCategory = new Category();
        $mainCategory->setName('Teszt Fő kategória');
        $mainCategory->setEnabled(true);
        $mainCategory->setContext($defaultContext);
        
        $manager->persist($mainCategory);
        
        $subCategory1 = new Category();
        $subCategory1->setParent($mainCategory);
        $subCategory1->setName('Al kategória 1');
        $subCategory1->setEnabled(true);
        $subCategory1->setContext($defaultContext);
        
        
        $manager->persist($subCategory1);

        $subCategory2 = new Category();
        $subCategory2->setParent($mainCategory);
        $subCategory2->setName('Al kategória 2');
        $subCategory2->setEnabled(true);
        $subCategory2->setContext($defaultContext);
        
        $manager->persist($subCategory2);
        $manager->flush();
        
        $this->createProduct($manager, $subCategory1, 'Alaplap 1', 'MB001');
        $this->createProduct($manager, $subCategory1, 'Alaplap 2', 'MB002');
        $this->createProduct($manager, $subCategory2, 'Monitor 1', 'DISP001');
        $this->createProduct($manager, $subCategory2, 'Monitor 2', 'DISP002');
    }
    
    private function createProduct(ObjectManager $manager, Category $category, string $name, string $productNumber): void
    {
        $product = (new Product())
            ->setName($name)
            ->setProductNumber($productNumber)
            ->setDescription('Teszt termék leírás')
            ->setCategory($category)
            ->setPrice(rand(10, 50)*100)
            ->setActualStockAmount(rand(2,15))
        ;
        
        $manager->persist($product);
        $initProductStore = (new ProductStoreActivity())
            ->setProduct($product)
            ->setAmount($product->getActualStockAmount())
            ->setAction(ProductStoreAction::Init)
        ;
        $manager->persist($initProductStore);
        $manager->flush();
    }
    
}
