<?php

namespace App\Entity;

use App\Repository\ShopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShopRepository::class)]
class Shop
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $shop_name;

    #[ORM\Column(type: 'datetime_immutable')]
    private $shop_created_at;

    #[ORM\OneToOne(inversedBy: 'shop', targetEntity: User::class, cascade: ['persist', 'remove'])]
    private $shop_owner;

    #[ORM\OneToMany(mappedBy: 'product_shop', targetEntity: Product::class)]
    private $shop_products;

    public function __construct()
    {
        $this->shop_created_at = new \DateTimeImmutable();
        $this->shop_products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShopName(): ?string
    {
        return $this->shop_name;
    }

    public function setShopName(string $shop_name): self
    {
        $this->shop_name = $shop_name;

        return $this;
    }

    public function getShopCreatedAt(): ?\DateTimeImmutable
    {
        return $this->shop_created_at;
    }

    public function setShopCreatedAt(\DateTimeImmutable $shop_created_at): self
    {
        $this->shop_created_at = $shop_created_at;

        return $this;
    }

    public function getShopOwner(): ?User
    {
        return $this->shop_owner;
    }

    public function setShopOwner(?User $shop_owner): self
    {
        $this->shop_owner = $shop_owner;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getShopProducts(): Collection
    {
        return $this->shop_products;
    }

    public function addShopProduct(Product $shopProduct): self
    {
        if (!$this->shop_products->contains($shopProduct)) {
            $this->shop_products[] = $shopProduct;
            $shopProduct->setProductShop($this);
        }

        return $this;
    }

    public function removeShopProduct(Product $shopProduct): self
    {
        if ($this->shop_products->removeElement($shopProduct)) {
            // set the owning side to null (unless already changed)
            if ($shopProduct->getProductShop() === $this) {
                $shopProduct->setProductShop(null);
            }
        }

        return $this;
    }
}
