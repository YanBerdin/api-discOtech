<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230608083004 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE album_style (album_id INT NOT NULL, style_id INT NOT NULL, INDEX IDX_4505F24C1137ABCF (album_id), INDEX IDX_4505F24CBACD6074 (style_id), PRIMARY KEY(album_id, style_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE album_style ADD CONSTRAINT FK_4505F24C1137ABCF FOREIGN KEY (album_id) REFERENCES album (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE album_style ADD CONSTRAINT FK_4505F24CBACD6074 FOREIGN KEY (style_id) REFERENCES style (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE album_style DROP FOREIGN KEY FK_4505F24C1137ABCF');
        $this->addSql('ALTER TABLE album_style DROP FOREIGN KEY FK_4505F24CBACD6074');
        $this->addSql('DROP TABLE album_style');
    }
}
