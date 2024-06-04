<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240525053837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE announcement (id INT AUTO_INCREMENT NOT NULL, published_by_id INT NOT NULL, validated_by_id INT DEFAULT NULL, property_id INT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, description VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, sponsored TINYINT(1) NOT NULL, sponsor_date DATE DEFAULT NULL, sponsor_duration INT NOT NULL, available TINYINT(1) NOT NULL, contact_phone VARCHAR(255) NOT NULL, images LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_4DB9D91C989D9B62 (slug), INDEX IDX_4DB9D91C5B075477 (published_by_id), INDEX IDX_4DB9D91CC69DE5E5 (validated_by_id), INDEX IDX_4DB9D91C549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property (id INT AUTO_INCREMENT NOT NULL, city_id INT NOT NULL, type VARCHAR(255) NOT NULL, action VARCHAR(255) NOT NULL, INDEX IDX_8BF21CDE8BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, announcement_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, evaluation INT NOT NULL, date_review DATE NOT NULL, INDEX IDX_794381C6A76ED395 (user_id), INDEX IDX_794381C6913AEA17 (announcement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, last_name VARCHAR(100) NOT NULL, first_name VARCHAR(100) NOT NULL, phone_num VARCHAR(30) NOT NULL, black_listed TINYINT(1) DEFAULT 0 NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_announcement (user_id INT NOT NULL, announcement_id INT NOT NULL, INDEX IDX_CD75A51EA76ED395 (user_id), INDEX IDX_CD75A51E913AEA17 (announcement_id), PRIMARY KEY(user_id, announcement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE announcement ADD CONSTRAINT FK_4DB9D91C5B075477 FOREIGN KEY (published_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE announcement ADD CONSTRAINT FK_4DB9D91CC69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE announcement ADD CONSTRAINT FK_4DB9D91C549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6913AEA17 FOREIGN KEY (announcement_id) REFERENCES announcement (id)');
        $this->addSql('ALTER TABLE user_announcement ADD CONSTRAINT FK_CD75A51EA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_announcement ADD CONSTRAINT FK_CD75A51E913AEA17 FOREIGN KEY (announcement_id) REFERENCES announcement (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE announcement DROP FOREIGN KEY FK_4DB9D91C5B075477');
        $this->addSql('ALTER TABLE announcement DROP FOREIGN KEY FK_4DB9D91CC69DE5E5');
        $this->addSql('ALTER TABLE announcement DROP FOREIGN KEY FK_4DB9D91C549213EC');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE8BAC62AF');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6A76ED395');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6913AEA17');
        $this->addSql('ALTER TABLE user_announcement DROP FOREIGN KEY FK_CD75A51EA76ED395');
        $this->addSql('ALTER TABLE user_announcement DROP FOREIGN KEY FK_CD75A51E913AEA17');
        $this->addSql('DROP TABLE announcement');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE property');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_announcement');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
