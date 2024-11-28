<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241128012412 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D19EB6921 ON commande (client_id)');
        $this->addSql('ALTER TABLE ligne_de_commande ADD commande_id INT NOT NULL, ADD produit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ligne_de_commande ADD CONSTRAINT FK_7982ACE682EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE ligne_de_commande ADD CONSTRAINT FK_7982ACE6F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('CREATE INDEX IDX_7982ACE682EA2E54 ON ligne_de_commande (commande_id)');
        $this->addSql('CREATE INDEX IDX_7982ACE6F347EFB ON ligne_de_commande (produit_id)');
        $this->addSql('ALTER TABLE produit ADD categorie_id INT NOT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27BCF5E72D ON produit (categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D19EB6921');
        $this->addSql('DROP INDEX IDX_6EEAA67D19EB6921 ON commande');
        $this->addSql('ALTER TABLE commande DROP client_id');
        $this->addSql('ALTER TABLE ligne_de_commande DROP FOREIGN KEY FK_7982ACE682EA2E54');
        $this->addSql('ALTER TABLE ligne_de_commande DROP FOREIGN KEY FK_7982ACE6F347EFB');
        $this->addSql('DROP INDEX IDX_7982ACE682EA2E54 ON ligne_de_commande');
        $this->addSql('DROP INDEX IDX_7982ACE6F347EFB ON ligne_de_commande');
        $this->addSql('ALTER TABLE ligne_de_commande DROP commande_id, DROP produit_id');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27BCF5E72D');
        $this->addSql('DROP INDEX IDX_29A5EC27BCF5E72D ON produit');
        $this->addSql('ALTER TABLE produit DROP categorie_id');
    }
}
