<?php

declare(strict_types=1);

namespace App\Entity\Webshop;

use App\Entity\AbstractBaseEntity;
use App\Entity\Classification\Category;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\{PrePersistEventArgs, PreUpdateEventArgs};

#[ORM\Entity]
#[ORM\Table(name: 'webshop_order_item')]
#[ORM\HasLifecycleCallbacks]
class OrderItem extends AbstractBaseEntity
{
    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id')]
    private Product $product;

    #[ORM\ManyToOne(targetEntity: Order::class)]
    #[ORM\JoinColumn(name: 'order_id', referencedColumnName: 'id')]
    private Order $order;
    
    #[ORM\Column(type: Types::STRING)]
    private string $name;
    
    #[ORM\Column(type: Types::STRING)]
    private string $productNumber;
    
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;
    
    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id')]
    private Category $category;
    
    #[ORM\Column(type: Types::INTEGER, options: ['default' => 0])]
    private int $unitPrice;
    
    #[ORM\Column(type: Types::INTEGER)]
    private int $amount;
    
    #[ORM\Column(type: Types::INTEGER, options: ['default' => 0])]
    private int $sumPrice;
    
    
    public function getProduct(): Product
    {
        return $this->product;
    }
    
    public function getOrder(): Order
    {
        return $this->order;
    }
    
    public function getName(): string
    {
        return $this->name;
    }

    public function getProductNumber(): string
    {
        return $this->productNumber;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
    
    public function getCategory(): Category
    {
        return $this->category;
    }
    
    public function getUnitPrice(): int
    {
        return $this->unitPrice;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
    
    public function getSumPrice(): int
    {
        return $this->sumPrice;
    }
    
    public function setProduct(Product $product): self
    {
        $this->product = $product;
        
        return $this;
    }
    
    public function setOrder(Order $order): self
    {
        $this->order = $order;
        
        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        
        return $this;
    }

    public function setProductNumber(string $productNumber): self
    {
        $this->productNumber = $productNumber;
        
        return $this;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        
        return $this;
    }
    
    public function setCategory(Category $category): self
    {
        $this->category = $category;
        
        return $this;
    }
    
    public function setUnitPrice(int $unitPrice): self
    {
        $this->unitPrice = $unitPrice;
        
        return $this;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;
        
        return $this;
    }
    
    public function setSumPrice(int $sumPrice): self
    {
        $this->sumPrice = $sumPrice;
        
        return $this;
    }
    
    public function __toString(): string
    {
        return $this->product->getId() . '-' . $this->name . ' ('. $this->productNumber . '): '. $this->amount . ' db ('. $this->unitPrice . ') '. $this->sumPrice;
    }
    
    #[ORM\PrePersist]
    public function onPrePersist(PrePersistEventArgs $eventArgs)
    {
        $this->onCreateSetTimes();
    }
    
    #[ORM\PreUpdate]
    public function onPreUpdate(PreUpdateEventArgs $eventArgs)
    {
        $this->onUpdateSetTime();
    }
    
}
