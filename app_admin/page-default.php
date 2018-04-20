<!DOCTYPE html>
<html>
  <head>
    <?php get_head() ?>
  </head>
  <body>
    <main>
      <nav>
        <?php get_partial( '/app_admin/navbar/navbar-top' ) ?>
      </nav>
      <div class=''>
        <?php get_partial( '/app_admin/navbar/navbar-side' ) ?>
        <?php get_content() ?>
        <?php get_partial( '/app_admin/navbar/navbar-options' ) ?>
      </div>
      <div>
        <?php get_partial( 'footer' ) ?>
      </div>
    </main>
    <?php get_footer() ?>
  </body>
</html>
