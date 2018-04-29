<form method='POST' action='' class='form form-admin'>
  <div class='wrap'>
    <h2>Website</h2>
    <div class='installation-steps'>
      <span content="Connection" class="active"></span>
      <span content="Website" class="active"></span>
      <span content="Database"></span>
      <span content="Done!"></span>
    </div>
    <div class='form-collection'>
      <div class='form-row'>
        <div class='form-label'>
          <div class='attribute'>Website name</div>
          <div class='description'>The name of the website</div>
        </div>
        <div class='form-control'>
          <input name="MiiConfig[app_name]" placeholder="Project" value="<?=$config->app_name?>" type="text"/>
        </div>
        <label><?=$config->getFirstError('app_name')?></label>
      </div>
    </div>
    <div class='form-collection'>
      <div class='form-row'>
        <div class='form-label'>
          <div class='attribute'>Database prefix</div>
          <div class='description'>The prefix that'll be used to base the database tables on <br/> ( ie: myprefix_post )</div>
        </div>
        <div class='form-control'>
          <input name="MiiConfig[app_prefix]" placeholder="Project_" value="<?=$config->app_prefix?>" type="text"/>
        </div>
        <label><?=$config->getFirstError('app_prefix')?></label>
      </div>
    </div>
    <div class='form-collection'>
      <div class='form-row'>
        <div class='form-label'>
          <div class='attribute'>Admin dashboard</div>
          <div class='description'>The subdomain to use to log into the dashboard.</div>
        </div>
        <div class='form-control'>
          <label class='form-control-prefix'><?=site_protocol(). "://"?></label>
          <input name="MiiConfig[admin_subdomain]" placeholder="Project_" value="<?=$config->admin_subdomain?>" type="text"/>
          <label class='form-control-suffix'>.<?=site_url()?></label>
        </div>
        <label><?=$config->getFirstError('admin_subdomain')?></label>
      </div>
    </div>
  </div>
  <div class='wrap'>
    <button type="submit" class="btn flat inactive-success-main active-success-accent large pull-right">install database</button>
  </div>
</form>
