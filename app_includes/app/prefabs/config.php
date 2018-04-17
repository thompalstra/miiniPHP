<?php
$config = <<<CONFIG
<?php
define( "DB_NAME",     "{$db_name}" );
define( "DB_HOST",     "{$db_host}" );
define( "DB_USER",     "{$db_user}" );
define( "DB_PASSWORD", "{$db_password}" );

define( "APP_NAME",    "{$app_name}");
define( "APP_PREFIX",    "{$app_prefix}");

define( "APP_USER", "{$app_user}" );
define( "APP_PASSWORD", "{$app_user}" );
CONFIG;
?>
