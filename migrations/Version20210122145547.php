<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210122145547 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exam (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, test_id INT NOT NULL, started_at DATETIME DEFAULT NULL, stopped_at DATETIME DEFAULT NULL, INDEX IDX_38BBA6C6A76ED395 (user_id), INDEX IDX_38BBA6C61E5D0459 (test_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE qcm (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE qcm_question (qcm_id INT NOT NULL, question_id INT NOT NULL, INDEX IDX_572B6C8DFF6241A6 (qcm_id), INDEX IDX_572B6C8D1E27F6BF (question_id), PRIMARY KEY(qcm_id, question_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, text LONGTEXT NOT NULL, answers LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE result (id INT AUTO_INCREMENT NOT NULL, sequence INT NOT NULL, answered_at DATETIME NOT NULL, answereds LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', point INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE still_question (id INT AUTO_INCREMENT NOT NULL, based_question_id INT NOT NULL, test_id INT NOT NULL, text LONGTEXT NOT NULL, answers LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_6728575313454915 (based_question_id), INDEX IDX_672857531E5D0459 (test_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test (id INT AUTO_INCREMENT NOT NULL, based_qcm_id INT NOT NULL, planned_at DATETIME DEFAULT NULL, active TINYINT(1) NOT NULL, INDEX IDX_D87F7E0CEAF0506A (based_qcm_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exam ADD CONSTRAINT FK_38BBA6C6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE exam ADD CONSTRAINT FK_38BBA6C61E5D0459 FOREIGN KEY (test_id) REFERENCES test (id)');
        $this->addSql('ALTER TABLE qcm_question ADD CONSTRAINT FK_572B6C8DFF6241A6 FOREIGN KEY (qcm_id) REFERENCES qcm (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE qcm_question ADD CONSTRAINT FK_572B6C8D1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE still_question ADD CONSTRAINT FK_6728575313454915 FOREIGN KEY (based_question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE still_question ADD CONSTRAINT FK_672857531E5D0459 FOREIGN KEY (test_id) REFERENCES test (id)');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0CEAF0506A FOREIGN KEY (based_qcm_id) REFERENCES qcm (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE qcm_question DROP FOREIGN KEY FK_572B6C8DFF6241A6');
        $this->addSql('ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0CEAF0506A');
        $this->addSql('ALTER TABLE qcm_question DROP FOREIGN KEY FK_572B6C8D1E27F6BF');
        $this->addSql('ALTER TABLE still_question DROP FOREIGN KEY FK_6728575313454915');
        $this->addSql('ALTER TABLE exam DROP FOREIGN KEY FK_38BBA6C61E5D0459');
        $this->addSql('ALTER TABLE still_question DROP FOREIGN KEY FK_672857531E5D0459');
        $this->addSql('ALTER TABLE exam DROP FOREIGN KEY FK_38BBA6C6A76ED395');
        $this->addSql('DROP TABLE exam');
        $this->addSql('DROP TABLE qcm');
        $this->addSql('DROP TABLE qcm_question');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE result');
        $this->addSql('DROP TABLE still_question');
        $this->addSql('DROP TABLE test');
        $this->addSql('DROP TABLE user');
    }
}
