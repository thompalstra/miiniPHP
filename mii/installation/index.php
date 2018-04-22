 <?php

include( 'functions.php' );

$dir = Mii::$app->dir;
$ds = Mii::$app->ds;

Mii::$app->rdir = "{$dir}mii{$ds}installation{$ds}";

get_partial( 'page-install' );
?>
