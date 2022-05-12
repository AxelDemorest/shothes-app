<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $category_name;

    #[ORM\OneToMany(mappedBy: 'product_category', targetEntity: Product::class)]
    private $category_products;

    #[ORM\Column(type: 'datetime_immutable')]
    private $category_created_at;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $category_icon;

    public function __construct()
    {
        $this->category_products = new ArrayCollection();
        $this->category_created_at = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryName(): ?string
    {
        return $this->category_name;
    }

    public function setCategoryName(string $category_name): self
    {
        $this->category_name = $category_name;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getCategoryProducts(): Collection
    {
        return $this->category_products;
    }

    public function addCategoryProduct(Product $categoryProduct): self
    {
        if (!$this->category_products->contains($categoryProduct)) {
            $this->category_products[] = $categoryProduct;
            $categoryProduct->setProductCategory($this);
        }

        return $this;
    }

    public function removeCategoryProduct(Product $categoryProduct): self
    {
        if ($this->category_products->removeElement($categoryProduct)) {
            // set the owning side to null (unless already changed)
            if ($categoryProduct->getProductCategory() === $this) {
                $categoryProduct->setProductCategory(null);
            }
        }

        return $this;
    }

    public function getCategoryCreatedAt(): ?\DateTimeImmutable
    {
        return $this->category_created_at;
    }

    public function setCategoryCreatedAt(\DateTimeImmutable $category_created_at): self
    {
        $this->category_created_at = $category_created_at;

        return $this;
    }

    public function __toString() {
        return $this->category_name;
    }

    public function getCategoryIcon(): ?string
    {
        return $this->category_icon;
    }

    public function setCategoryIcon(?string $category_icon): self
    {
        $this->category_icon = $category_icon;

        return $this;
    }

    public function getCategoryIconPath(): string
    {
        return 'uploads/category_image/'.$this->getCategoryIcon();
    }
}
