<?php
$config = <<<CONFIG
<?php
define( "DB_NAME", "{$config->db_name}" );

define( "DB_HOST" "{$config->db_host}" );

define( "DB_USER", "{$config->db_user}" );

define( "DB_PASSWORD", "{$config->db_password}" );


define( "APP_NAME", "{%config_app_name%}" );

define( "APP_PREFIX", "{%config_app_prefix%}" );

define( "ADMIN_SUBDOMAIN", "{%config_admin_subdomain%}" );
CONFIG;
?>
