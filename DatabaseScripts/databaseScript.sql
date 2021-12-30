USE `quant-zadatak`;

DROP TABLE IF EXISTS doctrine_migration_versions;

ALTER TABLE image DROP FOREIGN KEY FK_C53D045FA76ED395;

ALTER TABLE image
    ADD CONSTRAINT fk_image_user_id FOREIGN KEY (user_id)
    REFERENCES user(id)
    ON DELETE CASCADE;

ALTER TABLE gallery DROP FOREIGN KEY FK_472B783AA76ED395;

ALTER TABLE gallery
    ADD CONSTRAINT fk_gallery_user_id FOREIGN KEY (user_id)
    REFERENCES user(id)
    ON DELETE CASCADE;

ALTER TABLE image_gallery DROP FOREIGN KEY FK_D23B2FE63DA5256D;

ALTER TABLE image_gallery
    ADD CONSTRAINT fk_image_id FOREIGN KEY (image_id)
    REFERENCES image(id)
    ON DELETE CASCADE;

ALTER TABLE image_gallery DROP FOREIGN KEY FK_D23B2FE64E7AF8F;

ALTER TABLE image_gallery
    ADD CONSTRAINT fk_gallery_id FOREIGN KEY (gallery_id)
    REFERENCES gallery(id)
    ON DELETE CASCADE;

ALTER TABLE comment DROP FOREIGN KEY FK_9474526C3DA5256D;

ALTER TABLE comment
    ADD CONSTRAINT fk_image_comment_id FOREIGN KEY (image_id)
    REFERENCES image(id)
    ON DELETE CASCADE;

ALTER TABLE comment DROP FOREIGN KEY FK_9474526C4E7AF8F;

ALTER TABLE comment
    ADD CONSTRAINT fk_gallery_comment_id FOREIGN KEY (gallery_id)
    REFERENCES gallery(id)
    ON DELETE CASCADE;

ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395;

ALTER TABLE comment
    ADD CONSTRAINT fk_user_comment_id FOREIGN KEY (user_id)
    REFERENCES user(id)
    ON DELETE CASCADE;

CREATE TABLE logger
    (
        id INT AUTO_INCREMENT PRIMARY KEY ,
        user_id INT NOT NULL,
        image_id INT NULL,
        gallery_id INT NULL,
        comment LONGTEXT NOT NULL,
        date DATETIME,
        CONSTRAINT fk_logger_user_id FOREIGN KEY (user_id)
            REFERENCES user(id)
            ON DELETE CASCADE,
        CONSTRAINT fk_logger_image_id FOREIGN KEY (image_id)
            REFERENCES image(id)
            ON DELETE CASCADE,
        CONSTRAINT fk_logger_gallery_id FOREIGN KEY (gallery_id)
            REFERENCES gallery(id)
            ON DELETE CASCADE
)
COLLATE = utf8mb4_unicode_ci;
