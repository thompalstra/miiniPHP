<?php
/**
 * Template Name: Default home template
 * Description: Template for default home
 *
 * @package Package name
 * @subpackage Project name
 */
?>

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
        <?php get_content() ?>
      </div>
      <div>
      </div>
    </main>
    <?php get_footer() ?>
  </body>
</html>
