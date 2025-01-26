<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Cocur\Slugify\Slugify;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Scalar\Float_;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[UniqueEntity('title', message: 'Il existe déjà un produit avec ce titre')]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $title;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(nullable: false)]
    #[Assert\NotBlank]
    private ?int $price;

    #[ORM\Column]
    private ?string $merchant = null;

    #[ORM\Column]
    private float $weight = 0;

    #[ORM\Column]
    private ?string $category = null;

    #[ORM\Column(type: Types::STRING, nullable: true, length: 255)]
    private ?string $imageFileName = null;

    public function getImageFileName(): ?string
    {
        return $this->imageFileName;
    }
    public function setImageFileName(?string $imageFileName): void
    {
        $this->imageFileName = $imageFileName;
    }
    public function getMerchant(): ?string
    {
        return $this->merchant;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): void
    {
        $this->category = $category;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }

    public function setMerchant(?string $merchant): void
    {
        $this->merchant = $merchant;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): static
    {
        $this->price = $price;

        return $this;
    }
    public function getFormattedPrice(): string
    {
        return number_format($this->price, 0, '', ' ');
    }

    public function getSlugify(): string
    {
        $slugify = new Slugify();
        return $slugify->slugify($this->title);
    }
}
