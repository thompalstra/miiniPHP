<head>
  <link href='/app_common/css/app.core.css' rel="stylesheet"/>
  <script src='/app_common/js/app.core.js'></script>

  <title>Miini | Installation</title>
</head>
<body>
  <form method='POST' action='' class='form form-admin'>
    <div class='wrap'>
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
          <!-- <div class="password-strength" data-score="0">
            <div class='message'></div>
            <div class="track">
              <span class='section'></span>
              <span class='section'></span>
              <span class='section'></span>
              <span class='section'></span>
              <span class='section'></span>
            </div>
          </div> -->
        </div>
      </div>
    </div>
    <div class='wrap'>
      <button type="submit" class="btn flat inactive-success-main active-success-accent large">install database</button>
    </div>
  </form>
  <script>
    document.addEventListener('DOMContentLoaded', function( event ) {
      // document.querySelector('[name="Config[app][user][password]"]').addEventListener( 'input', function( event ) {
      //   var score = 0;
      //   var pwd = this.value;
      //   var messages = [];
      //
      //   if( /[a-z]/.test( pwd ) ){
      //     score += 1;
      //
      //   } else { message = "Password should contain at least 1 lowercase letter."; }
      //
      //   if( /[A-Z]/.test( pwd ) ){
      //     score += 1;
      //   } else { message = "Password should contain at least 1 UPPERCASE letter."; };
      //
      //   if( /[0-9]/.test( pwd ) ){
      //     score += 1;
      //   } else { message = "Password should contain at least 1 number."; };
      //
      //   if( /[!@#$%^&*()]/.test( pwd ) ){
      //     score += 1;
      //   } else { message = "Password should contain at least 1 special character <em>! @ # $ % ^ &  ( )</em>."; };
      //
      //   if( ( pwd.length > 6 ) ){
      //     score += 1;
      //   } else { message = "Password should be at least 6 characters."; };
      //
      //   document.querySelector('.message').innerHTML = message;
      //
      //   this.nextElementSibling.dataset.score = score;
      //
      // } );
    } );
  </script>
</body>
