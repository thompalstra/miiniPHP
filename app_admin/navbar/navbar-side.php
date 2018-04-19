navbar side
<nav>
  <section>
    <?php
    $prefix = App::$app->prefix;
    $post_types = query_execute( "SELECT * FROM {$prefix}post_type" );

    $posts = ( new Query() )->select('*')
      ->from( "{$prefix}post_type" )
      ->all();
    ?>
    <?php foreach( $posts as $post ) : ?>
      <li> <?=$post['label_plural'] ?>
        <ul>
          <li>
            <a href="/<?=$post['slug']?>/create">New <?=$post['label_singular'] ?></a></li>
          <li><a href="/<?=$post['slug']?>/index">Manage <?=$post['label_plural'] ?> </a></li>
        </ul>
      </li>
    <?php endforeach; ?>
  </section>
</nav>
