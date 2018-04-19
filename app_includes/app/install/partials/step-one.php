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
      </div>
    </div>

    <div class='wrap'>
      <button type="submit" class="btn flat inactive-gray-main active-action-accent large">install</button>
    </div>

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
    } );
  </script>
</body>
