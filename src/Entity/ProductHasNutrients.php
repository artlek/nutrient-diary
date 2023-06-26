<?php

namespace App\Entity;

use App\Repository\ProductHasNutrientsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductHasNutrientsRepository::class)]
class ProductHasNutrients
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'hasProducts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Nutrient $nutrients = null;

    #[ORM\ManyToOne(inversedBy: 'hasNutrients')]
    private ?Product $products = null;

    #[ORM\Column]
    #[Assert\NotNull]
    #[Assert\Type('float')]
    #[Assert\Range(
        min: 0,
        max: 100,
        notInRangeMessage: 'Content must be between {{ min }} and {{ max }} g (ml)',
    )]
    private ?float $quantity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNutrients(): ?Nutrient
    {
        return $this->nutrients;
    }

    public function setNutrients(?Nutrient $nutrients): self
    {
        $this->nutrients = $nutrients;

        return $this;
    }

    public function getProducts(): ?Product
    {
        return $this->products;
    }

    public function setProducts(?Product $products): self
    {
        $this->products = $products;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): self
    {
        $this->quantity = round($quantity, 2);

        return $this;
    }
}
