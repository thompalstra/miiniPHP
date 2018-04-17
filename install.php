<?php

if( $_POST && !defined( 'APP_NAME' ) ){
  $config = (object) $_POST['Config'];
  $app = get_app();

  $app_name = $config->app['name'];
  $app_prefix = $config->app['prefix'];
  $app_user = $config->app['user']['username'];
  $app_password = $config->app['user']['password'];
  $db_name = $config->app['db']['name'];
  $db_user = $config->app['db']['user'];
  $db_password = $config->app['db']['password'];
  $db_host = $config->app['db']['host'];

  include( "{$app->dir}{$app->ds}app_includes{$app->ds}app{$app->ds}prefabs{$app->ds}config.php" );
  // include( "{$app->dir}{$app->ds}app_includes{$app->ds}app{$app->ds}prefabs{$app->ds}db.php" );

  $myfile = fopen("{$app->dir}{$app->ds}app-config.php", "w") or die("Unable to config file!");
  fwrite($myfile, $config);
  fclose($myfile);

  $app->redirect('/install');
}

if( !defined( 'APP_NAME' ) ){

  ?>
  <head>
    <link href='/app_common/css/app.core.css' rel="stylesheet"/>
    <script src='/app_common/js/app.core.js'></script>

    <title>Miini | Installation</title>
  </head>
  <body>
    <form method='POST' action='' class='form form-admin'>
      <div class='wrap'>
        <div class='form-collection'>
          <h2>MySQL configuration</h2>
          <div class='form-row'>
            <div class='form-label'>
              <div class='attribute'>MYSQL host</div>
              <div class='description'>The host we should connect to (default localhost).</div>
            </div>
            <div class='form-control'>
              <input name="Config[app][db][host]" placeholder="localhost" value="localhost" type="text"/>
            </div>
          </div>
          <div class='form-row'>
            <div class='form-label'>
              <div class='attribute'>MYSQL database</div>
              <div class='description'>The name of the database we're going to be connecting to.</div>
            </div>
            <div class='form-control'>
              <input name="Config[app][db][name]" placeholder="admin" value="database" type="text"/>
            </div>
          </div>
          <div class='form-row'>
            <div class='form-label'>
              <div class='attribute'>MYSQL username</div>
              <div class='description'>The username we're going to use to log edit the database with.</div>
            </div>
            <div class='form-control'>
              <input name="Config[app][db][user]" placeholder="root" value="root" type="text"/>
            </div>
          </div>
          <div class='form-row'>
            <div class='form-label'>
              <div class='attribute'>MYSQL password</div>
              <div class='description'>The MYSQL user's password.</div>
            </div>
            <div class='form-control'>
              <input name="Config[app][db][password]" placeholder="" value="" type="text"/>
            </div>
          </div>
        </div>

        <div class='form-collection'>
          <h2>Application configuration</h2>
          <div class='form-row'>
            <div class='form-label'>
              <div class='attribute'>Website name</div>
              <div class='description'>The name of the website</div>
            </div>
            <div class='form-control'>
              <input name="Config[app][name]" placeholder="Project" value="Project" type="text"/>
            </div>
          </div>
          <div class='form-row'>
            <div class='form-label'>
              <div class='attribute'>Database prefix</div>
              <div class='description'>The prefix that'll be used to base the database tables on <br/> ( ie: myprefix_post )</div>
            </div>
            <div class='form-control'>
              <input name="Config[app][prefix]" placeholder="Project_" value="project_" type="text"/>
            </div>
          </div>
          <div class='form-row'>
            <div class='form-label'>
              <div class='attribute'>Username</div>
              <div class='description'>The username your user is going to use to log into the administrative panel.</div>
            </div>
            <div class='form-control'>
              <input name="Config[app][user][username]" placeholder="admin" value="admin" type="text"/>
            </div>
          </div>
          <div class='form-row'>
            <div class='form-label'>
              <div class='attribute'>Password</div>
              <div class='description'>The password of your user.</div>
            </div>
            <div class='form-control'>
              <input name="Config[app][user][password]" placeholder="admin" value="admin" type="password" />
              <div class="password-strength" data-score="0">
                <div class='message'></div>
                <div class="track">
                  <span class='section'></span>
                  <span class='section'></span>
                  <span class='section'></span>
                  <span class='section'></span>
                  <span class='section'></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <button type="submit">install</button>
    </form>

    <script>
      document.addEventListener('DOMContentLoaded', function( event ) {
        document.querySelector('[name="Config[app][name]"]').addEventListener( 'change', function( event ) {
          if( this.value.length == 0 ){
            this.value = this.placeholder;
            this.dispatchEvent( new Event( 'input', {
              cancelable: false,
              bubbles: false
            } ) );
          }
        } );
        document.querySelector('[name="Config[app][name]"]').addEventListener( 'input', function( event ) {
          var value = this.value.toLowerCase();
          value = value.replace(/ /g, "_");
          value = value + "_";
          document.querySelector('[name="Config[app][prefix]"]').value = value;
          console.log('chg');
        } );

        document.querySelector('[name="Config[app][user][password]"]').addEventListener( 'input', function( event ) {
          var score = 0;
          var pwd = this.value;
          var messages = [];

          if( /[a-z]/.test( pwd ) ){
            score += 1;

          } else { messages.push( "Password should contain at least 1 lowercase letter." ) }

          if( /[A-Z]/.test( pwd ) ){
            score += 1;
          } else { messages.push( "Password should contain at least 1 UPPERCASE letter." ) };

          if( /[0-9]/.test( pwd ) ){
            score += 1;
          } else { messages.push( "Password should contain at least 1 number." ) };

          if( /[!@#$%^&*()]/.test( pwd ) ){
            score += 1;
          } else { messages.push( "Password should contain at least 1 special character <em>! @ # $ % ^ &  ( )</em>." ) };

          if( ( pwd.length > 6 ) ){
            score += 1;
          } else { messages.push( "Password should be at least 6 characters." ) };

          if( messages.length == 0 ){
            message = "Password is strong.";
          } else {
            if( score < 3 ){
              messages.push( "Password is weak" );
            } else {
              messages.push( "Password is not weak" );
            }
            message = messages.join( "\r\n" );
          }

          document.querySelector('.message').innerHTML = message;

          // score += ( /[a-z]/.test( pwd ) ) ? 1 : 0;
          // score += ( /[A-Z]/.test( pwd ) ) ? 1 : 0;
          // score += ( /[0-9]/.test( pwd ) ) ? 1 : 0;
          // score += ( /[!@#$%^&*()]/.test( pwd ) ) ? 1 : 0;
          // score += ( pwd.length > 6 ) ? 1 : 0;

          this.nextElementSibling.dataset.score = score;

        } );
      } );
    </script>
  </body>
<?php
}
if( defined( 'APP_NAME' ) && !defined( 'APP_INSTALLED' ) ){
  if( $_POST ){
    $prefix = APP_PREFIX;
    $user = APP_USER;
    $password = APP_PASSWORD;

    $app = get_app();

    include( "{$app->dir}{$app->ds}app_includes{$app->ds}app{$app->ds}prefabs{$app->ds}db.php" );

    if( query_execute( $initial ) ){

      echo 'installation success';

      $myfile = fopen("{$app->dir}{$app->ds}app-config.php", "a") or die("Unable to config file!");

$installed = <<<CONFIG

define( "APP_INSTALLED", true );

CONFIG;

      fwrite($myfile,  $installed );
      fclose($myfile);

      $app->redirect('/');
    }
  } else {
    ?>
    <form method='POST'>
      <input name="install" value="install" type="hidden"/>
      <button type="submit">install database</button>
    </form>
    <?php
  }
}
