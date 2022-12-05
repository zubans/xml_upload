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
    private $name;

    #[ORM\Column(type: 'string', length: 1000)]
    private $description;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $weigth;

    #[ORM\Column(type: 'string', nullable: true)]
    private $weightPrecision;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $category;

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

    public function getWeigth(): ?int
    {
        return $this->weigth;
    }

    public function setWeigth(?int $weigth): self
    {
        $this->weigth = $weigth;

        return $this;
    }

    public function getWeightPrecision(): ?string
    {
        return $this->weightPrecision;
    }

    public function setWeightPrecision(?string $weightPrecision): self
    {
        $this->weightPrecision = $weightPrecision;

        return $this;
    }

    public function getCategoryId(): ?Category
    {
        return $this->category;
    }

    public function setCategoryId(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
