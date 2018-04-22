<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dir = __DIR__ . DIRECTORY_SEPARATOR;
$ds = DIRECTORY_SEPARATOR;

include( "{$dir}mii{$ds}autoload.php" );
include( "{$dir}mii{$ds}app.php" );

return App::run();
?>
