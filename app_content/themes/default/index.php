<?php
$app = get_app();
$app->basePath = "{$app->dir}/app_content/themes/{$app->theme}/";

function handle_path( $path ){
  if( $path == '/' ){
    $path = 'home';
  }
  get_app()->path = $path;
  echo render();
}
function render(){
  // render template
  $app = get_app();

  $fp = "{$app->basePath}default-template.php";

  ob_start();
  require( $fp );
  $content = ob_get_contents();
  ob_end_clean();

  return $content;
}

function get_head(){
  echo get_partial( 'head' );
}

function get_footer(){
  echo get_partial( 'footer' );
}

function get_template(){

}

function get_content(){
  // render view
  $app = get_app();
  return get_partial( "$app->path" );
}




handle_path( $route['path'] );
?>
