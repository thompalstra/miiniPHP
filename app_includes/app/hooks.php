<?php
return array (
  'render' => [
    'native' => function(){
        $template = App::$app->page['template'];
        $fp = App::$app->basePath . "{$template}.php";

        ob_start();
        require( $fp );
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;
    }
    ],
  'handle_path' => [
    'native' => function( $path ){
        $prefix = App::$app->prefix;
        App::$app->page = query_posts( [
          'post_type' => get_setting('page_post_type'),
          'params' => [
            [ get_setting('page_search_by') => $path ]
          ],
          'limit' => 1,
        ] )[0];

        if( empty( App::$app->page ) ){
          App::$app->page = [
            'template' => '404'
          ];
        }
        return hook( 'render' );
    },
  ],
  'get_partial' => [
    'native' => function( $path, $output = false ){
      $app = get_app();

      if( $path[0] == '/' ){
        $path = $app->dir . $path;
      } else {
        $path = $app->basePath . $path;
      }

      foreach( $app->partialExtensions as $ext ) :
        $fp = "{$path}{$ext}";
        if( file_exists( $fp ) ) :
          ob_start();
          require( $fp );
          $content = ob_get_contents();
          ob_end_clean();
          if( $output == true ){
            return $content;
          } else {
            echo $content;
          }
        endif;
      endforeach;
    }
  ],
  'get_head' => function(){
    return hook( 'get_partial', "head" );
  },
  'get_footer' => function(){
    return hook( 'get_partial', "footer" );
  },
  'get_content' => function(){
    var_Dump( App::$app->c );
    return hook( 'get_partial', App::$app->path );
  },
)
?>
