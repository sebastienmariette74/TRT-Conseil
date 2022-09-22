<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220922064402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC144F779A2');
        $this->addSql('DROP INDEX IDX_A45BDDC144F779A2 ON application');
        $this->addSql('ALTER TABLE application DROP consultant_id');
        $this->addSql('ALTER TABLE job_offer DROP FOREIGN KEY FK_288A3A4E44F779A2');
        $this->addSql('DROP INDEX IDX_288A3A4E44F779A2 ON job_offer');
        $this->addSql('ALTER TABLE job_offer DROP consultant_id, CHANGE recruiter_id recruiter_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application ADD consultant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC144F779A2 FOREIGN KEY (consultant_id) REFERENCES consultant (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_A45BDDC144F779A2 ON application (consultant_id)');
        $this->addSql('ALTER TABLE job_offer ADD consultant_id INT DEFAULT NULL, CHANGE recruiter_id recruiter_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE job_offer ADD CONSTRAINT FK_288A3A4E44F779A2 FOREIGN KEY (consultant_id) REFERENCES consultant (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_288A3A4E44F779A2 ON job_offer (consultant_id)');
    }
}
