<?php

namespace App\Entity;

use App\Repository\ProductHasNutrientsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductHasNutrientsRepository::class)]
class ProductHasNutrients
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\ManyToOne(cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Nutrient $nutrient = null;

    #[ORM\Column]
    private ?float $content = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getNutrient(): ?Nutrient
    {
        return $this->nutrient;
    }

    public function setNutrient(?Nutrient $nutrient): static
    {
        $this->nutrient = $nutrient;

        return $this;
    }

    public function getContent(): ?float
    {
        return $this->content;
    }

    public function setContent(float $content): static
    {
        $this->content = $content;

        return $this;
    }
}
