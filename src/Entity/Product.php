<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $product_title;

    #[ORM\Column(type: 'integer')]
    private $product_price;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $product_description;

    #[ORM\Column(type: 'datetime_immutable')]
    private $product_created_at;

    #[ORM\ManyToOne(targetEntity: Shop::class, inversedBy: 'shop_products')]
    private $product_shop;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'category_products')]
    #[ORM\JoinColumn(nullable: false)]
    private $product_category;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private $product_author;

    #[ORM\Column(type: 'string', length: 255)]
    private $product_images;

    public function __construct()
    {
        $this->product_created_at = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductTitle(): ?string
    {
        return $this->product_title;
    }

    public function setProductTitle(string $product_title): self
    {
        $this->product_title = $product_title;

        return $this;
    }

    public function getProductPrice(): ?int
    {
        return $this->product_price;
    }

    public function setProductPrice(int $product_price): self
    {
        $this->product_price = $product_price;

        return $this;
    }

    public function getProductDescription(): ?string
    {
        return $this->product_description;
    }

    public function setProductDescription(?string $product_description): self
    {
        $this->product_description = $product_description;

        return $this;
    }

    public function getProductCreatedAt(): ?\DateTimeImmutable
    {
        return $this->product_created_at;
    }

    public function setProductCreatedAt(\DateTimeImmutable $product_created_at): self
    {
        $this->product_created_at = $product_created_at;

        return $this;
    }

    public function getProductShop(): ?Shop
    {
        return $this->product_shop;
    }

    public function setProductShop(?Shop $product_shop): self
    {
        $this->product_shop = $product_shop;

        return $this;
    }

    public function getProductCategory(): ?Category
    {
        return $this->product_category;
    }

    public function setProductCategory(?Category $product_category): self
    {
        $this->product_category = $product_category;

        return $this;
    }

    public function getProductAuthor(): ?User
    {
        return $this->product_author;
    }

    public function setProductAuthor(?User $product_author): self
    {
        $this->product_author = $product_author;

        return $this;
    }

    public function getProductImages(): ?string
    {
        return $this->product_images;
    }

    public function setProductImages(string $product_images): self
    {
        $this->product_images = $product_images;

        return $this;
    }

    public function getImagePath(): string
    {
        return 'uploads/product_image/'.$this->getProductImages();
    }
}
