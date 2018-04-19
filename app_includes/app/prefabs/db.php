<?php
$initial = <<<MYSQL
  CREATE TABLE IF NOT EXISTS {$prefix}user (
    id              INT(11) AUTO_INCREMENT PRIMARY KEY,
    username        VARCHAR(255),
    password        VARCHAR(255),
    is_published    TINYINT(1),
    is_system       TINYINT(1)
  );

  INSERT INTO {$prefix}user
    ( username, password, is_published, is_system )
    VALUES ( "$username", "$password", 1, 1 );

  CREATE TABLE IF NOT EXISTS {$prefix}post (
    id                INT(11) AUTO_INCREMENT PRIMARY KEY,
    post_type_id      INT(11),
    title             VARCHAR(255),
    slug              VARCHAR(255),
    description       TEXT,
    is_published      TINYINT(1)
  );

  INSERT INTO {$prefix}post
    ( post_type_id, title, slug, description, is_published )
    VALUES ( 1, "Home", "/", "My homepage", 1 );

  CREATE TABLE IF NOT EXISTS {$prefix}post_type (
    id                INT(11) AUTO_INCREMENT PRIMARY KEY,
    title             VARCHAR(255),
    slug              VARCHAR(255),
    label_singular    VARCHAR(255),
    label_plural      VARCHAR(255),
    is_system         TINYINT(1)
  );

  INSERT INTO {$prefix}post_type
    ( title, slug, label_singular, label_plural, is_system )
    VALUES ( "Page", "page", "Page", "Pages", 1 );

  CREATE TABLE IF NOT EXISTS {$prefix}post_type_field (
    id                INT(11) AUTO_INCREMENT PRIMARY KEY,
    post_type_id      INT(11),
    title             VARCHAR(255),
    slug              VARCHAR(255),
    field_type        VARCHAR(255)
  );

  CREATE TABLE IF NOT EXISTS {$prefix}post_post_type_field (
    id                INT(11) AUTO_INCREMENT PRIMARY KEY,
    post_id           INT(11),
    field_value       TEXT
  );

  CREATE TABLE IF NOT EXISTS {$prefix}category (
    id                INT(11) AUTO_INCREMENT PRIMARY KEY,
    post_type_id      INT(11),
    title             VARCHAR(255),
    slug              VARCHAR(255)
  );

  CREATE TABLE IF NOT EXISTS {$prefix}post_category (
    id                INT(11) AUTO_INCREMENT PRIMARY KEY,
    post_id           INT(11),
    category_id       INT(11)
  );
MYSQL;
?>
