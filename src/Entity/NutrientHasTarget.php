<?php

namespace App\Entity;

use App\Repository\NutrientHasTargetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NutrientHasTargetRepository::class)]
class NutrientHasTarget
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $target = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Nutrient $nutrient = null;

    #[ORM\Column]
    private ?int $userId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTarget(): ?float
    {
        return $this->target;
    }

    public function setTarget(float $target): static
    {
        $this->target = $target;

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

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

}
