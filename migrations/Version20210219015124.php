<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210219015124 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE channel (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE channel_user (channel_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_11C7753772F5A1AA (channel_id), INDEX IDX_11C77537A76ED395 (user_id), PRIMARY KEY(channel_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media_object (id INT AUTO_INCREMENT NOT NULL, file_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE channel_user ADD CONSTRAINT FK_11C7753772F5A1AA FOREIGN KEY (channel_id) REFERENCES channel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE channel_user ADD CONSTRAINT FK_11C77537A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message ADD user_id INT NOT NULL, ADD channel_id INT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F72F5A1AA FOREIGN KEY (channel_id) REFERENCES channel (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FA76ED395 ON message (user_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F72F5A1AA ON message (channel_id)');
        $this->addSql('ALTER TABLE post_it ADD user_id INT NOT NULL, ADD promotion_id INT DEFAULT NULL, ADD school_id INT NOT NULL, ADD close_answer TINYINT(1) NOT NULL, DROP seen, DROP clase_answer');
        $this->addSql('ALTER TABLE post_it ADD CONSTRAINT FK_563E1348A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE post_it ADD CONSTRAINT FK_563E1348139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id)');
        $this->addSql('ALTER TABLE post_it ADD CONSTRAINT FK_563E1348C32A47EE FOREIGN KEY (school_id) REFERENCES school (id)');
        $this->addSql('CREATE INDEX IDX_563E1348A76ED395 ON post_it (user_id)');
        $this->addSql('CREATE INDEX IDX_563E1348139DF194 ON post_it (promotion_id)');
        $this->addSql('CREATE INDEX IDX_563E1348C32A47EE ON post_it (school_id)');
        $this->addSql('ALTER TABLE promotion ADD school_id INT NOT NULL');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD1C32A47EE FOREIGN KEY (school_id) REFERENCES school (id)');
        $this->addSql('CREATE INDEX IDX_C11D7DD1C32A47EE ON promotion (school_id)');
        $this->addSql('ALTER TABLE user ADD avatar_id INT NOT NULL, ADD school_id INT NOT NULL, ADD promotion_id INT NOT NULL, ADD slugger VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64986383B10 FOREIGN KEY (avatar_id) REFERENCES media_object (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649C32A47EE FOREIGN KEY (school_id) REFERENCES school (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64986383B10 ON user (avatar_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649C32A47EE ON user (school_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649139DF194 ON user (promotion_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE channel_user DROP FOREIGN KEY FK_11C7753772F5A1AA');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F72F5A1AA');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D64986383B10');
        $this->addSql('DROP TABLE channel');
        $this->addSql('DROP TABLE channel_user');
        $this->addSql('DROP TABLE media_object');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FA76ED395');
        $this->addSql('DROP INDEX IDX_B6BD307FA76ED395 ON message');
        $this->addSql('DROP INDEX IDX_B6BD307F72F5A1AA ON message');
        $this->addSql('ALTER TABLE message DROP user_id, DROP channel_id');
        $this->addSql('ALTER TABLE post_it DROP FOREIGN KEY FK_563E1348A76ED395');
        $this->addSql('ALTER TABLE post_it DROP FOREIGN KEY FK_563E1348139DF194');
        $this->addSql('ALTER TABLE post_it DROP FOREIGN KEY FK_563E1348C32A47EE');
        $this->addSql('DROP INDEX IDX_563E1348A76ED395 ON post_it');
        $this->addSql('DROP INDEX IDX_563E1348139DF194 ON post_it');
        $this->addSql('DROP INDEX IDX_563E1348C32A47EE ON post_it');
        $this->addSql('ALTER TABLE post_it ADD clase_answer TINYINT(1) NOT NULL, DROP user_id, DROP promotion_id, DROP school_id, CHANGE close_answer seen TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE promotion DROP FOREIGN KEY FK_C11D7DD1C32A47EE');
        $this->addSql('DROP INDEX IDX_C11D7DD1C32A47EE ON promotion');
        $this->addSql('ALTER TABLE promotion DROP school_id');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649C32A47EE');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649139DF194');
        $this->addSql('DROP INDEX IDX_8D93D64986383B10 ON `user`');
        $this->addSql('DROP INDEX IDX_8D93D649C32A47EE ON `user`');
        $this->addSql('DROP INDEX IDX_8D93D649139DF194 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP avatar_id, DROP school_id, DROP promotion_id, DROP slugger');
    }
}
