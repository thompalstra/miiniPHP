<form method='POST' action='' class='form form-admin'>
  <div class='wrap'>
    <h2>Connection</h2>
    <div class='installation-steps'>
      <span content="Connection" class='active'></span>
      <span content="Website"></span>
      <span content="Database"></span>
      <span content="Done!"></span>
    </div>
    <div class='form-collection'>
      <div class='form-row'>
        <div class='form-label'>
          <div class='attribute'>Database host</div>
          <div class='description'>The domain or IP-address of the host we're going to be connecting to.</div>
        </div>
        <div class='form-control'>
          <input name="MiiConfig[db_host]" placeholder="localhost" value="<?=$config->db_host?>" type="text"/>
          <label><?=$config->getFirstError('db_host')?></label>
        </div>
      </div>
    </div>
    <div class='form-collection'>
      <div class='form-row'>
        <div class='form-label'>
          <div class='attribute'>Database name</div>
          <div class='description'>The name of the database we're going to use.</div>
        </div>
        <div class='form-control'>
          <input name="MiiConfig[db_name]" placeholder="admin" value="<?=$config->db_name?>" type="text"/>
          <label><?=$config->getFirstError('db_name')?></label>
        </div>
      </div>
    </div>
    <div class='form-collection'>
      <div class='form-row'>
        <div class='form-label'>
          <div class='attribute'>Username</div>
          <div class='description'>The username we will use to performs changes to the database.</div>
        </div>
        <div class='form-control'>
          <input name="MiiConfig[db_user]" placeholder="root" value="<?=$config->db_user?>" type="text"/>
          <label><?=$config->getFirstError('db_user')?></label>
        </div>
      </div>
    </div>
    <div class='form-collection'>
      <div class='form-row'>
        <div class='form-label'>
          <div class='attribute'>Password</div>
          <div class='description'>The password for the user.</div>
        </div>
        <div class='form-control'>
          <input name="MiiConfig[db_password]" placeholder="" value="<?=$config->db_password?>" type="text"/>
          <label><?=$config->getFirstError('db_password')?></label>
        </div>
      </div>
    </div>
  </div>

  <div class='wrap'>
    <button type="submit" class="btn flat inactive-action-main active-action-accent large pull-right">Create configuration</button>
  </div>

</form>

<script>
  document.addEventListener('DOMContentLoaded', function( event ) {
    document.querySelector('[name="MiiConfig[app_name]"]').addEventListener( 'change', function( event ) {
      if( this.value.length == 0 ){
        this.value = this.placeholder;
        this.dispatchEvent( new Event( 'input', {
          cancelable: false,
          bubbles: false
        } ) );
      }
    } );
    document.querySelector('[name="MiiConfig[app_name]"]').addEventListener( 'input', function( event ) {
      var value = this.value.toLowerCase();
      value = value.replace(/ /g, "_");
      value = value + "_";
      document.querySelector('[name="MiiConfig[app_prefix]"]').value = value;
      console.log('chg');
    } );
  } );
</script>
