<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\ORM\Mapping\Table;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[Table(
    name: 'product',
    options: ['comment' => 'Product table']
)]
#[HasLifecycleCallbacks]
class Product
{
    #[ORM\Id]
//    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(
        name: 'price',
        type: 'float',
        precision: 2,
        options: ['comment' => 'Product price'],
    )]
    private float $price;

    #[ORM\Column(
        name: 'created_at',
        type: 'datetimetz',
        options: ['comment' => 'Date of creation'],
    )]
    protected ?DateTimeInterface $createdAt = null;

    #[ORM\Column(
        name: 'updated_at',
        type: 'datetimetz',
        options: ['comment' => 'Modification date']
    )]
    protected DateTimeInterface $updatedAt;


    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    #[PrePersist]
    public function setCreatedAtValue(): void
    {
        if ($this->createdAt === null) {
            $this->createdAt = new DateTime();
        }
    }

    #[PrePersist]
    #[PreUpdate]
    public function setUpdatedAtValue(): void
    {
        $this->updatedAt = new DateTime();
    }

    /* Setters */
    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }
}
