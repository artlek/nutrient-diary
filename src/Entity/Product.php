<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'products', targetEntity: ProductHasNutrients::class)]
    private Collection $hasNutrients;

    private ?float $fat = null;

    private ?float $carbo = null;

    private ?float $protein = null;

    #[ORM\Column]
    private ?bool $isDeleted = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->hasNutrients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, ProductHasNutrients>
     */
    public function getHasNutrients(): Collection
    {
        return $this->hasNutrients;
    }

    public function addHasNutrient(ProductHasNutrients $hasNutrient): self
    {
        if (!$this->hasNutrients->contains($hasNutrient)) {
            $this->hasNutrients->add($hasNutrient);
            $hasNutrient->setProducts($this);
        }

        return $this;
    }

    public function removeHasNutrient(ProductHasNutrients $hasNutrient): self
    {
        if ($this->hasNutrients->removeElement($hasNutrient)) {
            // set the owning side to null (unless already changed)
            if ($hasNutrient->getProducts() === $this) {
                $hasNutrient->setProducts(null);
            }
        }

        return $this;
    }

    public function getFat(): ?float
    {
        return $this->fat;
    }

    public function setFat(float $fat): self
    {
        $this->fat = $fat;

        return $this;
    }

    public function getCarbo(): ?float
    {
        return $this->carbo;
    }

    public function setCarbo(float $carbo): self
    {
        $this->carbo = $carbo;

        return $this;
    }

    public function getProtein(): ?float
    {
        return $this->protein;
    }

    public function setProtein(float $protein): self
    {
        $this->protein = $protein;

        return $this;
    }

    public function isIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): static
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
