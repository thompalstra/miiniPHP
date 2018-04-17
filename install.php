<?php

?>
<head>
  <link href='/app_admin/css/app.core.css' rel="stylesheet"/>
  <title>Miini | Installation</title>
</head>
<body>
  <div class='wrap'>
    <form method='POST' action='' class='form form-admin'>
      <div class='form-row'>
        <div class='form-label'>
          Project naam
        </div>
        <div class='form-control'>
          <input name="Config[app][name]" placeholder="Project" value= "Project"/>
        </div>
      </div>
      <div class='form-row'>
        <div class='form-label'>
          Database prefix
        </div>
        <div class='form-control'>
          <input name="Config[app][table_prefix]" placeholder="Project_" value="project_"/>
        </div>
      </div>

      <div class='form-row'>
        <div class='form-label'>
          Username
        </div>
        <div class='form-control'>
          <input name="Config[app][user][username]" placeholder="admin" value="admin"/>
        </div>
      </div>

      <div class='form-row'>
        <div class='form-label'>
          Password
        </div>
        <div class='form-control'>
          <input name="Config[app][user][password]" placeholder="admin" type="password" value="admin"/>
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

      <button type="submit">submit</button>
    </form>
  </div>

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
        document.querySelector('[name="Config[app][table_prefix]"]').value = value;
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
