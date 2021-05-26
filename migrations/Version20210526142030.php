<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210526142030 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE album_creative_method_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE album_environment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE album_language_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE album_symbol_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE series_creative_method_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE series_environment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE series_symbol_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE video_language_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE album (id INT NOT NULL, category_id INT DEFAULT NULL, contributor_id INT DEFAULT NULL, thumbnail_video_id INT DEFAULT NULL, page_number INT DEFAULT NULL, line_number INT DEFAULT NULL, player_number INT DEFAULT NULL, content_type VARCHAR(255) NOT NULL, content_subtype VARCHAR(255) NOT NULL, series_count INT NOT NULL, videos_count INT NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, position INT NOT NULL, share_count INT NOT NULL, download_count INT NOT NULL, link_count INT NOT NULL, play_count INT NOT NULL, total_interactions_count INT NOT NULL, approval_status VARCHAR(255) NOT NULL, rejection_reasons JSON NOT NULL, rejection_reason_other VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_39986E4312469DE2 ON album (category_id)');
        $this->addSql('CREATE INDEX IDX_39986E437A19A357 ON album (contributor_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_39986E433A6DBD ON album (thumbnail_video_id)');
        $this->addSql('CREATE TABLE album_to_subcategory_rels (album_id INT NOT NULL, album_subcategory_id INT NOT NULL, PRIMARY KEY(album_id, album_subcategory_id))');
        $this->addSql('CREATE INDEX IDX_848D1BF61137ABCF ON album_to_subcategory_rels (album_id)');
        $this->addSql('CREATE INDEX IDX_848D1BF6DA913440 ON album_to_subcategory_rels (album_subcategory_id)');
        $this->addSql('CREATE TABLE album_category (id INT NOT NULL, content_type VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE album_subcategory (id INT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_46D0701C12469DE2 ON album_subcategory (category_id)');
        $this->addSql('CREATE TABLE contributor (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE series (id INT NOT NULL, symbol_id INT DEFAULT NULL, creative_method_id INT DEFAULT NULL, environment_id INT DEFAULT NULL, album_id INT DEFAULT NULL, contributor_id INT DEFAULT NULL, keywords TEXT DEFAULT NULL, description TEXT DEFAULT NULL, name VARCHAR(255) NOT NULL, position INT NOT NULL, share_count INT NOT NULL, download_count INT NOT NULL, link_count INT NOT NULL, play_count INT NOT NULL, total_interactions_count INT NOT NULL, approval_status VARCHAR(255) NOT NULL, rejection_reasons JSON NOT NULL, rejection_reason_other VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3A10012DC0F75674 ON series (symbol_id)');
        $this->addSql('CREATE INDEX IDX_3A10012D45CC48DB ON series (creative_method_id)');
        $this->addSql('CREATE INDEX IDX_3A10012D903E3A94 ON series (environment_id)');
        $this->addSql('CREATE INDEX IDX_3A10012D1137ABCF ON series (album_id)');
        $this->addSql('CREATE INDEX IDX_3A10012D7A19A357 ON series (contributor_id)');
        $this->addSql('COMMENT ON COLUMN series.keywords IS \'(DC2Type:simple_array)\'');
        $this->addSql('COMMENT ON COLUMN series.description IS \'(DC2Type:simple_array)\'');
        $this->addSql('CREATE TABLE series_creative_method (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE series_environment (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE series_symbol (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE video (id INT NOT NULL, language_text_id INT DEFAULT NULL, language_subtitles_id INT DEFAULT NULL, language_voiceover_id INT DEFAULT NULL, series_id INT DEFAULT NULL, duration INT NOT NULL, thumbnail_image_url VARCHAR(255) NOT NULL, aspect_ratio VARCHAR(255) DEFAULT NULL, symbol_value DOUBLE PRECISION DEFAULT NULL, soundtrack VARCHAR(255) DEFAULT NULL, soundtrack_license VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, position INT NOT NULL, share_count INT NOT NULL, download_count INT NOT NULL, link_count INT NOT NULL, play_count INT NOT NULL, total_interactions_count INT NOT NULL, approval_status VARCHAR(255) NOT NULL, rejection_reasons JSON NOT NULL, rejection_reason_other VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7CC7DA2CCD40E21C ON video (language_text_id)');
        $this->addSql('CREATE INDEX IDX_7CC7DA2CE3C8D27F ON video (language_subtitles_id)');
        $this->addSql('CREATE INDEX IDX_7CC7DA2C2FF4768C ON video (language_voiceover_id)');
        $this->addSql('CREATE INDEX IDX_7CC7DA2C5278319C ON video (series_id)');
        $this->addSql('CREATE TABLE video_language (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE video_variant (id INT NOT NULL, video_id INT DEFAULT NULL, height INT NOT NULL, width INT NOT NULL, file_size INT NOT NULL, file_url VARCHAR(255) NOT NULL, embed_code VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_14AE560029C1004E ON video_variant (video_id)');
        $this->addSql('ALTER TABLE album ADD CONSTRAINT FK_39986E4312469DE2 FOREIGN KEY (category_id) REFERENCES album_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE album ADD CONSTRAINT FK_39986E437A19A357 FOREIGN KEY (contributor_id) REFERENCES contributor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE album ADD CONSTRAINT FK_39986E433A6DBD FOREIGN KEY (thumbnail_video_id) REFERENCES video (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE album_to_subcategory_rels ADD CONSTRAINT FK_848D1BF61137ABCF FOREIGN KEY (album_id) REFERENCES album (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE album_to_subcategory_rels ADD CONSTRAINT FK_848D1BF6DA913440 FOREIGN KEY (album_subcategory_id) REFERENCES album_subcategory (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE album_subcategory ADD CONSTRAINT FK_46D0701C12469DE2 FOREIGN KEY (category_id) REFERENCES album_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE series ADD CONSTRAINT FK_3A10012DC0F75674 FOREIGN KEY (symbol_id) REFERENCES series_symbol (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE series ADD CONSTRAINT FK_3A10012D45CC48DB FOREIGN KEY (creative_method_id) REFERENCES series_creative_method (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE series ADD CONSTRAINT FK_3A10012D903E3A94 FOREIGN KEY (environment_id) REFERENCES series_environment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE series ADD CONSTRAINT FK_3A10012D1137ABCF FOREIGN KEY (album_id) REFERENCES album (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE series ADD CONSTRAINT FK_3A10012D7A19A357 FOREIGN KEY (contributor_id) REFERENCES contributor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CCD40E21C FOREIGN KEY (language_text_id) REFERENCES video_language (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CE3C8D27F FOREIGN KEY (language_subtitles_id) REFERENCES video_language (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C2FF4768C FOREIGN KEY (language_voiceover_id) REFERENCES video_language (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C5278319C FOREIGN KEY (series_id) REFERENCES series (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE video_variant ADD CONSTRAINT FK_14AE560029C1004E FOREIGN KEY (video_id) REFERENCES video (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE album_to_subcategory_rels DROP CONSTRAINT FK_848D1BF61137ABCF');
        $this->addSql('ALTER TABLE series DROP CONSTRAINT FK_3A10012D1137ABCF');
        $this->addSql('ALTER TABLE album DROP CONSTRAINT FK_39986E4312469DE2');
        $this->addSql('ALTER TABLE album_subcategory DROP CONSTRAINT FK_46D0701C12469DE2');
        $this->addSql('ALTER TABLE album_to_subcategory_rels DROP CONSTRAINT FK_848D1BF6DA913440');
        $this->addSql('ALTER TABLE album DROP CONSTRAINT FK_39986E437A19A357');
        $this->addSql('ALTER TABLE series DROP CONSTRAINT FK_3A10012D7A19A357');
        $this->addSql('ALTER TABLE video DROP CONSTRAINT FK_7CC7DA2C5278319C');
        $this->addSql('ALTER TABLE series DROP CONSTRAINT FK_3A10012D45CC48DB');
        $this->addSql('ALTER TABLE series DROP CONSTRAINT FK_3A10012D903E3A94');
        $this->addSql('ALTER TABLE series DROP CONSTRAINT FK_3A10012DC0F75674');
        $this->addSql('ALTER TABLE album DROP CONSTRAINT FK_39986E433A6DBD');
        $this->addSql('ALTER TABLE video_variant DROP CONSTRAINT FK_14AE560029C1004E');
        $this->addSql('ALTER TABLE video DROP CONSTRAINT FK_7CC7DA2CCD40E21C');
        $this->addSql('ALTER TABLE video DROP CONSTRAINT FK_7CC7DA2CE3C8D27F');
        $this->addSql('ALTER TABLE video DROP CONSTRAINT FK_7CC7DA2C2FF4768C');
        $this->addSql('DROP SEQUENCE series_creative_method_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE series_environment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE series_symbol_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE video_language_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE album_creative_method_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE album_environment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE album_language_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE album_symbol_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE album_to_subcategory_rels');
        $this->addSql('DROP TABLE album_category');
        $this->addSql('DROP TABLE album_subcategory');
        $this->addSql('DROP TABLE contributor');
        $this->addSql('DROP TABLE series');
        $this->addSql('DROP TABLE series_creative_method');
        $this->addSql('DROP TABLE series_environment');
        $this->addSql('DROP TABLE series_symbol');
        $this->addSql('DROP TABLE video');
        $this->addSql('DROP TABLE video_language');
        $this->addSql('DROP TABLE video_variant');
    }
}
