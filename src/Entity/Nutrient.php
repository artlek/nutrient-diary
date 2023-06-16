<?php

namespace App\Entity;

use App\Repository\NutrientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NutrientRepository::class)]
class Nutrient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'nutrients', targetEntity: ProductHasNutrients::class)]
    private Collection $hasProducts;

    #[ORM\Column]
    private ?bool $isDeleted = null;

    public function __construct()
    {
        $this->hasProducts = new ArrayCollection();
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
    public function getHasProducts(): Collection
    {
        return $this->hasProducts;
    }

    public function addHasProduct(ProductHasNutrients $hasProduct): self
    {
        if (!$this->hasProducts->contains($hasProduct)) {
            $this->hasProducts->add($hasProduct);
            $hasProduct->setNutrients($this);
        }

        return $this;
    }

    public function removeHasProduct(ProductHasNutrients $hasProduct): self
    {
        if ($this->hasProducts->removeElement($hasProduct)) {
            // set the owning side to null (unless already changed)
            if ($hasProduct->getNutrients() === $this) {
                $hasProduct->setNutrients(null);
            }
        }

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
}
