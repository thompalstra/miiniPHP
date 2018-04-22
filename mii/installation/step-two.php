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
      </div>
    </div>
  </div>
  <div class='wrap'>
    <button type="submit" class="btn flat inactive-success-main active-success-accent large">install database</button>
  </div>
</form>