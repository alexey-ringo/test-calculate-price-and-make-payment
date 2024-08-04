<?php
declare(strict_types=1);

namespace App\Entity;

use App\Enum\DiscountTypeEnum;
use App\Repository\CouponRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;

#[ORM\Entity(repositoryClass: CouponRepository::class)]
#[Table(
    name: 'coupon',
    options: ['comment' => 'Coupon table']
)]
#[UniqueConstraint(columns: ['code'])]
#[HasLifecycleCallbacks]
class Coupon
{
    #[ORM\Id]
//    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(
        name: 'code',
        type: 'string',
        length: 16,
        options: ['comment' => 'coupon code']
    )]
    private string $code;

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
    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

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
