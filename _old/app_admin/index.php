<?php
$app = &App::$app;
$app->c = 0;
$app->basePath = "{$app->dir}{$app->ds}app_admin{$app->ds}";
add_hook( 'handle_path', function( $path ) {
    $path = substr( $path, 1, strlen( $path ) );
    $parts = explode( '/', $path );
    $prefix = App::$app->prefix;
    if( $path == '' ){
      set_template('page-default');
    } else {
      if( count( $parts ) == 1 ){
        $slug = $parts[0];
        App::$app->query = ( new Query( array(
          'class' => 'PostObject'
        ) ) )
          ->select("*")
          ->from("{$prefix}post_type pt")
          ->where([
            'and',
            [ "pt.slug" => $slug ]
          ]);
          set_template('page-post-types');
      } else if( count( $parts ) == 2 ) {
        $slug = $parts[0];
        $id = $parts[1];

        if( $id == 'create' ){
          // App::$app->query = array( new Post() );
        } else {
          App::$app->query = ( new Query( array(
            'class' => 'PostObject'
          ) ) )
            ->select("*")
            ->from("{$prefix}post p")
            ->leftJoin( "{$prefix}post_type pt ON pt.id = p.post_type_id" )
            ->where([
              'and',
              [ "pt.slug" => $parts[0] ],
              [ "p.id" => $id ]
            ]);
        }
        set_template('page-post-type');
      }
    }

    hook( 'render' );
} );


handle_path( $route['path'] );
?>
