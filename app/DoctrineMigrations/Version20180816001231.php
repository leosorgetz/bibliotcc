<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180816001231 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D64992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_8D93D649A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_8D93D649C05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(500) NOT NULL, description LONGTEXT NOT NULL, article VARCHAR(255) DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, firstPost TINYINT(1) NOT NULL, firstPostDate DATETIME NOT NULL, lastPost TINYINT(1) NOT NULL, lastPostDate DATETIME NOT NULL, studentId INT DEFAULT NULL, advisorId INT DEFAULT NULL, boardId INT DEFAULT NULL, INDEX IDX_2FB3D0EE98BF2F98 (studentId), INDEX IDX_2FB3D0EEB8D504F2 (advisorId), UNIQUE INDEX UNIQ_2FB3D0EE39393B26 (boardId), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE board (id INT AUTO_INCREMENT NOT NULL, scheduledTime DATETIME NOT NULL, advisorGrade DOUBLE PRECISION DEFAULT NULL, evaluatorOneGrade DOUBLE PRECISION DEFAULT NULL, evaluatorTwoGrade DOUBLE PRECISION DEFAULT NULL, observations LONGTEXT DEFAULT NULL, finalGrade DOUBLE PRECISION DEFAULT NULL, isFinalized TINYINT(1) DEFAULT NULL, isCanceled TINYINT(1) DEFAULT NULL, isPresented TINYINT(1) DEFAULT NULL, evaluatorOneId INT DEFAULT NULL, evaluatorTwoId INT DEFAULT NULL, semesterId INT DEFAULT NULL, projectId INT DEFAULT NULL, INDEX IDX_58562B4746B9DCBB (evaluatorOneId), INDEX IDX_58562B47710FE7EB (evaluatorTwoId), INDEX IDX_58562B47CB6D974C (semesterId), UNIQUE INDEX UNIQ_58562B476C9360F7 (projectId), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE semester (id INT AUTO_INCREMENT NOT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE98BF2F98 FOREIGN KEY (studentId) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEB8D504F2 FOREIGN KEY (advisorId) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE39393B26 FOREIGN KEY (boardId) REFERENCES board (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE board ADD CONSTRAINT FK_58562B4746B9DCBB FOREIGN KEY (evaluatorOneId) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE board ADD CONSTRAINT FK_58562B47710FE7EB FOREIGN KEY (evaluatorTwoId) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE board ADD CONSTRAINT FK_58562B47CB6D974C FOREIGN KEY (semesterId) REFERENCES semester (id)');
        $this->addSql('ALTER TABLE board ADD CONSTRAINT FK_58562B476C9360F7 FOREIGN KEY (projectId) REFERENCES project (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE98BF2F98');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEB8D504F2');
        $this->addSql('ALTER TABLE board DROP FOREIGN KEY FK_58562B4746B9DCBB');
        $this->addSql('ALTER TABLE board DROP FOREIGN KEY FK_58562B47710FE7EB');
        $this->addSql('ALTER TABLE board DROP FOREIGN KEY FK_58562B476C9360F7');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE39393B26');
        $this->addSql('ALTER TABLE board DROP FOREIGN KEY FK_58562B47CB6D974C');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE board');
        $this->addSql('DROP TABLE semester');
    }
}
