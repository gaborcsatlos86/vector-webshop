<?php

declare(strict_types=1);

namespace App\Entity\Webshop;

use App\Enums\ProductStoreAction;
use App\Entity\AbstractBaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class ProductStoreActivity extends AbstractBaseEntity
{
    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id')]
    private Product $product;
    
    #[ORM\Column(enumType: ProductStoreAction::class)]
    private ProductStoreAction $action;
    
    #[ORM\Column(type: Types::INTEGER, options: ['default' => 0])]
    private int $amount;
    
    public function getProduct(): Product
    {
        return $this->product;
    }
    
    public function getAction(): string
    {
        return $this->action->value;
    }
    
    public function getAmount(): int
    {
        return $this->amount;
    }
    
    public function setProduct(Product $product): self
    {
        $this->product = $product;
        
        return $this;
    }
    
    public function setAction(ProductStoreAction|string $action): self
    {
        if (is_string($action)) {
            $action = ProductStoreAction::findByValue($action);
        }
        $this->action = $action;
        
        return $this;
    }
    
    public function setAmount(int $amount): self
    {
        $this->amount = $amount;
        
        return $this;
    }
    
    #[ORM\PrePersist]
    public function onPrePersist(PrePersistEventArgs $eventArgs)
    {
        $this->onCreateSetTimes();
    }
    
}