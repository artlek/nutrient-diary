<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Regex('/^[\p{L}0-9\.)(,\s-]{2,30}$/u', message: 'Invalid data. Only digits, letters and dot, bracket, comma and dash mark allowed. Min. 2 and max. 30 characters.')]
    #[ORM\Column(length: 255)]
    #[Assert\NotNull]
    private ?string $name = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    #[ORM\Column]
    private ?bool $isDeleted = false;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductHasNutrients::class)]
    private Collection $productHasNutrients;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Diary::class)]
    private Collection $diaries;

    public function __construct()
    {
        $this->productHasNutrients = new ArrayCollection();
        $this->diaries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

        return $this;
    }

    public function isDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): static
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * @return Collection<int, ProductHasNutrients>
     */
    public function getProductHasNutrients(): Collection
    {
        return $this->productHasNutrients;
    }

    public function addProductHasNutrients(ProductHasNutrients $productHasNutrients): static
    {
        if (!$this->productHasNutrients->contains($productHasNutrients)) {
            $this->productHasNutrients->add($productHasNutrients);
            $productHasNutrients->setProduct($this);
        }

        return $this;
    }

    public function removeProductHasNutrients(ProductHasNutrients $productHasNutrients): static
    {
        if ($this->productHasNutrients->removeElement($productHasNutrients)) {
            // set the owning side to null (unless already changed)
            if ($productHasNutrients->getProduct() === $this) {
                $productHasNutrients->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Diary>
     */
    public function getDiaries(): Collection
    {
        return $this->diaries;
    }

    public function addDiary(Diary $diary): static
    {
        if (!$this->diaries->contains($diary)) {
            $this->diaries->add($diary);
            $diary->setProduct($this);
        }

        return $this;
    }

    public function removeDiary(Diary $diary): static
    {
        if ($this->diaries->removeElement($diary)) {
            // set the owning side to null (unless already changed)
            if ($diary->getProduct() === $this) {
                $diary->setProduct(null);
            }
        }

        return $this;
    }
}
