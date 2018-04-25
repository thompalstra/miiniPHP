<?php
$config = <<<CONFIG
<?php
define( "DB_NAME",       "{$config->db_name}" );
define( "DB_HOST",       "{$config->db_host}" );
define( "DB_USER",       "{$config->db_user}" );
define( "DB_PASSWORD",   "{$config->db_password}" );

define( "APP_NAME",      "{$config->app_name}" );
define( "APP_PREFIX",    "{$config->app_prefix}" );
CONFIG;
?>
