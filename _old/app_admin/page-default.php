<!DOCTYPE html>
<html>
  <head>
    <?php get_head(); ?>
  </head>
  <body>
    <main>
      <nav>
        <?php get_partial( '/app_admin/partials/navbar/navbar-top' ) ?>
      </nav>
      <div class=''>
        <?php get_partial( '/app_admin/partials/navbar/navbar-side' ) ?>
        <?php get_partial( '/app_admin/partials/home' ) ?>
        <?php get_partial( '/app_admin/partials/navbar/navbar-options' ) ?>
      </div>
      <div>
      </div>
      <?php get_footer() ?>
    </main>
  </body>
</html>
