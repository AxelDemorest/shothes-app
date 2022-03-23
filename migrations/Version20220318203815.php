<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220318203815 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD product_author_id INT NOT NULL, ADD product_images VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD98D54596 FOREIGN KEY (product_author_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD98D54596 ON product (product_author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category CHANGE category_name category_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD98D54596');
        $this->addSql('DROP INDEX IDX_D34A04AD98D54596 ON product');
        $this->addSql('ALTER TABLE product DROP product_author_id, DROP product_images, CHANGE product_title product_title VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE product_description product_description VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE shop CHANGE shop_name shop_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE pseudo pseudo VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
