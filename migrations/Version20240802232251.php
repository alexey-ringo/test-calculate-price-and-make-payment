<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240802232251 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TYPE discount_type_enum AS ENUM (\'fixed\', \'percent\')');
        $this->addSql('CREATE SEQUENCE coupon_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE coupon (id INT NOT NULL, code VARCHAR(16) NOT NULL, name VARCHAR(255) NOT NULL, discount_type discount_type_enum NOT NULL, discount INT NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64BF3F0277153098 ON coupon (code)');
        $this->addSql('COMMENT ON TABLE coupon IS \'Coupon table\'');
        $this->addSql('COMMENT ON COLUMN coupon.code IS \'coupon code\'');
        $this->addSql('COMMENT ON COLUMN coupon.name IS \'coupon name\'');
        $this->addSql('COMMENT ON COLUMN coupon.discount_type IS \'discount type\'');
        $this->addSql('COMMENT ON COLUMN coupon.created_at IS \'Date of creation\'');
        $this->addSql('COMMENT ON COLUMN coupon.updated_at IS \'Modification date\'');
        $this->addSql('CREATE TABLE product (id INT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON TABLE product IS \'Product table\'');
        $this->addSql('COMMENT ON COLUMN product.price IS \'Product price\'');
        $this->addSql('COMMENT ON COLUMN product.created_at IS \'Date of creation\'');
        $this->addSql('COMMENT ON COLUMN product.updated_at IS \'Modification date\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE coupon_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE product_id_seq CASCADE');
        $this->addSql('DROP TABLE coupon');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TYPE discount_type_enum');
    }
}
