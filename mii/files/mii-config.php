<?php
$config = <<<CONFIG
<?php
define( "DB_NAME",     "{$data->app->db->name}" );
define( "DB_HOST",     "{$data->app->db->host}" );
define( "DB_USER",     "{$data->app->db->user}" );
define( "DB_PASSWORD", "{$data->app->db->password}" );

define( "APP_NAME",    "{$data->app->name}");
define( "APP_PREFIX",    "{$data->app->prefix}");
CONFIG;
?>
