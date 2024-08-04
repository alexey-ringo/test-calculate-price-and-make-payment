<?php
declare(strict_types=1);

namespace App\Command;

use App\Entity\Coupon;
use App\Entity\Product;
use App\Enum\DiscountTypeEnum;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'default-data:set')]
class SetDefaultDataCommand extends Command
{
    /** @var array<array{id: int, name: string, price: float}> */
    private static array $products = [
        [
            'id' => 1,
            'name' => 'iPhone',
            'price' => 100.00,
        ],
        [
            'id' => 2,
            'name' => 'HeadSet',
            'price' => 20.00,
        ],
        [
            'id' => 3,
            'name' => 'Case',
            'price' => 10.00,
        ],
    ];

    /** @var array<array{id: int, code: string, name: string, discount_type: DiscountTypeEnum, discount: int}> */
    private static array $coupons = [
        [
            'id' => 1,
            'code' => 'P10',
            'name' => 'Discount 10 percents per purchase',
            'discount_type' => DiscountTypeEnum::PERCENT,
            'discount' => 10,
        ],
        [
            'id' => 2,
            'code' => 'P15',
            'name' => 'Discount 15 percents per purchase',
            'discount_type' => DiscountTypeEnum::PERCENT,
            'discount' => 15,
        ],
        [
            'id' => 3,
            'code' => 'P20',
            'name' => 'Discount 20 percents per purchase',
            'discount_type' => DiscountTypeEnum::PERCENT,
            'discount' => 20,
        ],
        [
            'id' => 4,
            'code' => 'F10',
            'name' => 'Discount 10 Euro per purchase',
            'discount_type' => DiscountTypeEnum::FIXED,
            'discount' => 10,
        ],
        [
            'id' => 5,
            'code' => 'F20',
            'name' => 'Discount 20 Euro per purchase',
            'discount_type' => DiscountTypeEnum::FIXED,
            'discount' => 20,
        ],
        [
            'id' => 6,
            'code' => 'F50',
            'name' => 'Discount 50 Euro per purchase',
            'discount_type' => DiscountTypeEnum::FIXED,
            'discount' => 50,
        ],
        [
            'id' => 7,
            'code' => 'F100',
            'name' => 'Discount 100 Euro per purchase',
            'discount_type' => DiscountTypeEnum::FIXED,
            'discount' => 100,
        ],
        [
            'id' => 8,
            'code' => 'F150',
            'name' => 'Discount 150 Euro per purchase',
            'discount_type' => DiscountTypeEnum::FIXED,
            'discount' => 150,
        ],
    ];

    public function __construct(
        private readonly CouponRepository $couponRepository,
        private readonly ProductRepository $productRepository,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->saveProduct();
        $this->saveCoupon();

        return Command::SUCCESS;
    }

    public function saveProduct(): void
    {
        foreach (self::$products as $data) {
            $product = $this->productRepository->find($data['id']);
            if ($product !== null && $product->getId() === $data['id']) {
                $this->updateProduct($product, $data);

                continue;
            }
            $this->createProduct($data);
        }
        $this->productRepository->flush();
    }

    /**
     * @param  array{id: int, name: string, price: float}  $data
     */
    private function createProduct(array $data): void
    {
        $entity = new Product();
        $entity->setId($data['id']);
        $entity->setName($data['name']);
        $entity->setPrice($data['price']);

        $this->productRepository->persist($entity);
    }

    /**
     * @param  array{name: string, price: float}  $data
     */
    private function updateProduct(Product $product, array $data): void
    {
        $product->setName($data['name']);
        $product->setPrice($data['price']);

        $this->productRepository->persist($product);
    }

    public function saveCoupon(): void
    {
        foreach (self::$coupons as $data) {
            $coupon = $this->couponRepository->find($data['id']);
            if ($coupon !== null && $coupon->getId() === $data['id']) {
                $this->updateCoupon($coupon, $data);
                continue;
            }
            $this->createCoupon($data);
        }
        $this->couponRepository->flush();
    }

    /**
     * @param  array{id: int, code: string, name: string, discount_type: DiscountTypeEnum, discount: int}  $data
     */
    private function createCoupon(array $data): void
    {
        $entity = new Coupon();
        $entity->setId($data['id']);
        $entity->setCode($data['code']);
        $entity->setName($data['name']);
        $entity->setDiscountType($data['discount_type']);
        $entity->setDiscount($data['discount']);

        $this->couponRepository->persist($entity);
    }

    /**
     * @param  array{code: string, name: string, discount_type: DiscountTypeEnum, discount: int}  $data
     */
    private function updateCoupon(Coupon $coupon, array $data): void
    {
        $coupon->setCode($data['code']);
        $coupon->setName($data['name']);
        $coupon->setDiscountType($data['discount_type']);
        $coupon->setDiscount($data['discount']);

        $this->couponRepository->persist($coupon);
    }
}
