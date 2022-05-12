<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToMany(targetEntity: Product::class)]
    private $order_products;

    public function __construct()
    {
        $this->order_products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getOrderProducts(): Collection
    {
        return $this->order_products;
    }

    public function addOrderProduct(Product $orderProduct): self
    {
        if (!$this->order_products->contains($orderProduct)) {
            $this->order_products[] = $orderProduct;
        }

        return $this;
    }

    public function removeOrderProduct(Product $orderProduct): self
    {
        $this->order_products->removeElement($orderProduct);

        return $this;
    }
}
