<?php
// var_dump(App::$app->queryResult); die;
var_dump( has_posts() );
// var_dump( get_posts() ); die;



?>


<?php if( has_posts() ) : ?>

  <?php foreach( get_posts() as $post ) : ?>
    <?php get_partial( '/app_admin/partials/post-type/form', array(
      'post' => $post
    ) ) ?>
  <?php endforeach ?>

<?php else : ?>

<?php endif ?>
