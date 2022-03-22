<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220304091800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, category_name VARCHAR(255) NOT NULL, category_created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop (id INT AUTO_INCREMENT NOT NULL, shop_owner_id INT DEFAULT NULL, shop_name VARCHAR(255) NOT NULL, shop_created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_AC6A4CA2A5849B6F (shop_owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shop ADD CONSTRAINT FK_AC6A4CA2A5849B6F FOREIGN KEY (shop_owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE product ADD product_shop_id INT DEFAULT NULL, ADD product_category_id INT NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD9CCFDF6D FOREIGN KEY (product_shop_id) REFERENCES shop (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADBE6903FD FOREIGN KEY (product_category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD9CCFDF6D ON product (product_shop_id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADBE6903FD ON product (product_category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADBE6903FD');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD9CCFDF6D');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE shop');
        $this->addSql('DROP INDEX IDX_D34A04AD9CCFDF6D ON product');
        $this->addSql('DROP INDEX IDX_D34A04ADBE6903FD ON product');
        $this->addSql('ALTER TABLE product DROP product_shop_id, DROP product_category_id, CHANGE product_title product_title VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE product_description product_description VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE pseudo pseudo VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
