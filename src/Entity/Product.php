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

    #[Assert\Regex('/^[a-zA-Z0-9\.)(,\s-]{3,50}$/', message: 'Invalid data. Only digits, letters and dot, bracket, comma and dash mark. Min. 3 and max. 50 characters.')]
    #[ORM\Column(length: 255)]
    #[Assert\Type('string')]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'products', targetEntity: ProductHasNutrients::class)]
    private Collection $hasNutrients;

    #[Assert\Type('float')]
    #[Assert\Range(
        min: 0,
        max: 100,
        notInRangeMessage: 'Fat content must be between {{ min }} and {{ max }} g (ml)',
    )]
    private ?float $fat = null;

    #[Assert\Type('float')]
    #[Assert\Range(
        min: 0,
        max: 100,
        notInRangeMessage: 'Carbohydrate content must be between {{ min }} and {{ max }} g (ml)',
    )]
    private ?float $carbo = null;

    #[Assert\Type('float')]
    #[Assert\Range(
        min: 0,
        max: 100,
        notInRangeMessage: 'Protein content must be between {{ min }} and {{ max }} g (ml)',
    )]
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
