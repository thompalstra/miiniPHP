<!DOCTYPE html>
<html>
  <head>
    <?php get_head() ?>
  </head>
  <body>
    <main>
      <nav>
        <?php get_partial( 'navbar-top' ) ?>
      </nav>
      <div class=''>
        <?php get_partial( 'navbar-side' ) ?>
        <?php get_content() ?>
        <?php get_partial( 'navbar-options' ) ?>
      </div>
      <div>
        <?php get_partial( 'footer' ) ?>
      </div>
    </main>
    <?php get_footer() ?>
  </body>
</html>
