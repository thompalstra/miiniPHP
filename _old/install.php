<?php
if( !defined( 'APP_NAME' ) ){
  include( "{$app->dir}{$app->ds}app_includes{$app->ds}app{$app->ds}install{$app->ds}step-one.php" );
} else if( defined( 'APP_NAME' ) && !defined( 'APP_INSTALLED' ) ){
  include( "{$app->dir}{$app->ds}app_includes{$app->ds}app{$app->ds}install{$app->ds}step-two.php" );
}
