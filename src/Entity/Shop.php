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

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $shop_icon;

    #[ORM\Column(type: 'text', nullable: true)]
    private $shop_description;

    #[ORM\Column(type: 'integer')]
    private $shop_layout;

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

    public function getShopIcon(): ?string
    {
        return $this->shop_icon;
    }

    public function setShopIcon(?string $shop_icon): self
    {
        $this->shop_icon = $shop_icon;

        return $this;
    }

    public function getShopIconPath(): string
    {
        return 'uploads/shop_image/'.$this->getShopIcon();
    }

    public function getShopDescription(): ?string
    {
        return $this->shop_description;
    }

    public function setShopDescription(?string $shop_description): self
    {
        $this->shop_description = $shop_description;

        return $this;
    }

    public function getShopLayout(): ?int
    {
        return $this->shop_layout;
    }

    public function setShopLayout(int $shop_layout): self
    {
        $this->shop_layout = $shop_layout;

        return $this;
    }
}
