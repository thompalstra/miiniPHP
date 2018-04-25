<?php

$password = password_hash( $config->password, PASSWORD_DEFAULT );
$initial = <<<MYSQL
  CREATE TABLE IF NOT EXISTS {$config->app_prefix}user (
    id              INT(11) AUTO_INCREMENT PRIMARY KEY,
    username        VARCHAR(255),
    password        VARCHAR(255),
    is_published    TINYINT(1),
    is_system       TINYINT(1)
  );

  INSERT INTO {$config->app_prefix}user
    ( username, password, is_published, is_system )
    VALUES ( "{$config->username}", "{$password}", 1, 1 );

  CREATE TABLE IF NOT EXISTS {$config->app_prefix}post (
    id                INT(11) AUTO_INCREMENT PRIMARY KEY,
    post_type_id      INT(11),
    title             VARCHAR(255),
    slug              VARCHAR(255),
    description       TEXT,
    template          VARCHAR(255),
    is_published      TINYINT(1)
  );

  INSERT INTO {$config->app_prefix}post
    ( post_type_id, title, slug, description, template, is_published )
    VALUES ( 1, "Home", "/", "My homepage", "default-template", 1 );

  CREATE TABLE IF NOT EXISTS {$config->app_prefix}post_type (
    id                INT(11) AUTO_INCREMENT PRIMARY KEY,
    title             VARCHAR(255),
    slug              VARCHAR(255),
    label_singular    VARCHAR(255),
    label_plural      VARCHAR(255),
    is_system         TINYINT(1)
  );

  INSERT INTO {$config->app_prefix}post_type
    ( title, slug, label_singular, label_plural, is_system )
    VALUES ( "Page", "page", "Page", "Pages", 1 );

  CREATE TABLE IF NOT EXISTS {$config->app_prefix}post_type_field (
    id                INT(11) AUTO_INCREMENT PRIMARY KEY,
    post_type_id      INT(11),
    title             VARCHAR(255),
    slug              VARCHAR(255),
    field_type        VARCHAR(255)
  );

  CREATE TABLE IF NOT EXISTS {$config->app_prefix}post_post_type_field (
    id                INT(11) AUTO_INCREMENT PRIMARY KEY,
    post_id           INT(11),
    field_value       TEXT
  );

  CREATE TABLE IF NOT EXISTS {$config->app_prefix}category (
    id                INT(11) AUTO_INCREMENT PRIMARY KEY,
    post_type_id      INT(11),
    title             VARCHAR(255),
    slug              VARCHAR(255)
  );

  CREATE TABLE IF NOT EXISTS {$config->app_prefix}post_category (
    id                INT(11) AUTO_INCREMENT PRIMARY KEY,
    post_id           INT(11),
    category_id       INT(11)
  );

  CREATE TABLE IF NOT EXISTS {$config->app_prefix}settings (
    id                INT(11) AUTO_INCREMENT PRIMARY KEY,
    settings_key      VARCHAR(255),
    settings_value    VARCHAR(255),
    description       VARCHAR(255)
  );

  INSERT INTO {$config->app_prefix}settings
    ( settings_key, settings_value, description )
    VALUES ( "page_search_by", "{$config->app_prefix}post.slug", "Change this attribute, to change the default field or attribute to match pages by." );

  INSERT INTO {$config->app_prefix}settings
    ( settings_key, settings_value, description )
    VALUES ( "page_post_type", "page", "Change this attribute, to change the default post type used for displaying pages." );

  INSERT INTO {$config->app_prefix}settings
    ( settings_key, settings_value, description )
    VALUES ( "current_theme", "default", "Change this attribute, to change the default theme used for displaying pages." );
MYSQL;
?>
