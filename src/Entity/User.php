<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseUser;


#[ORM\Entity]
#[ORM\UniqueConstraint(name: "email", columns: ["email"])]
class User extends BaseUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    protected $id;
    
    #[ORM\Column(type: Types::STRING)]
    private string $name;
    
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private string $address;
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function setName(string $name): self
    {
        $this->name = $name;
        
        return $this;
    }
    
    public function getAddress(): string
    {
        return $this->address;
    }
    
    public function setAddress(string $address): self
    {
        $this->address = $address;
        
        return $this;
    }
}
