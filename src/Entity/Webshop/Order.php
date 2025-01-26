<?php

declare(strict_types=1);

namespace App\Entity\Webshop;

use App\Entity\AbstractBaseEntity;
use App\Entity\User;
use App\Enums\OrderState;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Event\{PrePersistEventArgs, PreUpdateEventArgs};

#[ORM\Entity]
#[ORM\Table(name: 'webshop_order')]
#[ORM\HasLifecycleCallbacks]
class Order extends AbstractBaseEntity
{
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User $user;
    
    #[ORM\Column(type: Types::INTEGER, options: ['default' => 0])]
    private int $sumPrice;
    
    #[ORM\Column(enumType: OrderState::class, options: ['default' => OrderState::Created])]
    private OrderState $state;
    
    #[ORM\Column(type: Types::STRING)]
    private string $name;
    
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private string $address;
    
    #[ORM\OneToMany(targetEntity: OrderItem::class, mappedBy: 'order')]
    private Collection $items;
    
    public function __construct() {
        $this->items = new ArrayCollection();
    }
    
    public function getUser(): User
    {
        return $this->user;
    }
    
    public function getSumPrice(): int
    {
        return $this->sumPrice;
    }
    
    public function getState(): string
    {
        return $this->state->value;
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function getAddress(): string
    {
        return $this->address;
    }
    
    public function getItems(): Collection
    {
        return $this->items;
    }
    
    public function setUser(User $user): self
    {
        $this->user = $user;
        
        return $this;
    }
    
    public function setSumPrice(int $sumPrice): self
    {
        $this->sumPrice = $sumPrice;
        
        return $this;
    }
    
    public function setState(OrderState|string $state): self
    {
        if (is_string($state)) {
            $state = OrderState::findByValue($state);
        }
        $this->state = $state;
        
        return $this;
    }
    
    public function setName(string $name): self
    {
        $this->name = $name;
        
        return $this;
    }
    
    public function setAddress(string $address): self
    {
        $this->address = $address;
        
        return $this;
    }
    
    public function setItems(Collection $items): self
    {
        $this->items = $items;
        
        return $this;
    }
    
    public function addItem(OrderItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
        }
        
        return $this;
    }
    
    public function __toString(): string
    {
        return $this->id . '-order:' . $this->user->getEmail();
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