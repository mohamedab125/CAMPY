<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220427022955 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY fkId');
        $this->addSql('DROP INDEX id ON offre');
        $this->addSql('ALTER TABLE pub DROP FOREIGN KEY xx');
        $this->addSql('ALTER TABLE pub CHANGE id_sponsor id_sponsor INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pub ADD CONSTRAINT FK_5A443C855F1160A4 FOREIGN KEY (id_sponsor) REFERENCES sponsor (id_sponsor)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT fkId FOREIGN KEY (id) REFERENCES evenement (id)');
        $this->addSql('CREATE INDEX id ON offre (id)');
        $this->addSql('ALTER TABLE pub DROP FOREIGN KEY FK_5A443C855F1160A4');
        $this->addSql('ALTER TABLE pub CHANGE id_sponsor id_sponsor INT NOT NULL');
        $this->addSql('ALTER TABLE pub ADD CONSTRAINT xx FOREIGN KEY (id_sponsor) REFERENCES sponsor (id_sponsor) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
