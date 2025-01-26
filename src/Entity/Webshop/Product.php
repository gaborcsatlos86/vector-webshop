<?php

declare(strict_types=1);

namespace App\Entity\Webshop;

use App\Entity\AbstractBaseEntity;
use App\Entity\Classification\Category;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\{PrePersistEventArgs, PreUpdateEventArgs};

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\UniqueConstraint(name: "productNumber", columns: ["product_number"])]
class Product extends AbstractBaseEntity
{
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
    private int $price;
    
    #[ORM\Column(type: Types::INTEGER, options: ['default' => 0])]
    private int $actualStockAmount = 0;
    
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
    
    public function getPrice(): int
    {
        return $this->price;
    }

    public function getActualStockAmount(): int
    {
        return $this->actualStockAmount;
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
    
    public function setPrice(int $price): self
    {
        $this->price = $price;
        
        return $this;
    }

    public function setActualStockAmount(int $actualStockAmount): self
    {
        $this->actualStockAmount = $actualStockAmount;
        
        return $this;
    }
    
    public function increaseActualStockAmount(int $stockAmount): self
    {
        $this->actualStockAmount += $stockAmount;
        
        return $this;
    }
    
    public function decreaseActualStockAmount(int $stockAmount): self
    {
        $this->actualStockAmount -= $stockAmount;
        
        return $this;
    }
    
    public function __toString(): string
    {
        return $this->productNumber . ':' . $this->name;
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
