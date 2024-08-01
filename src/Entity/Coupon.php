<?php
declare(strict_types=1);

namespace App\Entity;

use App\Enum\DiscountTypeEnum;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Coupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(
        name: 'name',
        type: 'string',
        length: 255,
        options: ['comment' => 'coupon name']
    )]
    private string $name;

    #[ORM\Column(
        name: 'discount_type',
        type: 'string',
        enumType: DiscountTypeEnum::class,
        options: ['comment' => 'discount type']
    )]
    private DiscountTypeEnum $discountType;

    #[ORM\Column]
    private int $discount;

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

    public function getDiscountType(): DiscountTypeEnum
    {
        return $this->discountType;
    }

    public function setDiscountType(DiscountTypeEnum $discountTypeEnum): self
    {
        $this->discountType = $discountTypeEnum;

        return $this;
    }

    public function getDiscount(): int
    {
        return $this->discount;
    }

    public function setDiscount(int $discount): self
    {
        $this->discount = $discount;

        return $this;
    }
}
