<?php
namespace mii\installation\models;
class MiiConfig extends \mii\base\Model{

  const SCENARIO_DATABASE_CONNECT = 's0';
  const SCENARIO_APP_SETUP = 's1';
  const SCENARIO_DATABASE_CREATE = 's2';

  public $db_host = 'localhost';
  public $db_name = 'database';
  public $db_user = 'root';
  public $db_password = '';
  public $app_name = 'Project';
  public $app_prefix = 'project_';
  public $admin_subdomain = 'admin';

  public $username = 'admin';
  public $password = 'admin';

  public function rules(){
    return [
      [ [ 'db_host', 'db_name', 'db_user',
      'app_name', 'app_prefix' ],
        'required',
        'when' => self::SCENARIO_DATABASE_CONNECT
      ],
      [ [ 'db_password' ],
        'safe',
        'when' => self::SCENARIO_DATABASE_CONNECT
      ],
      [ [ 'username', 'password', 'admin_subdomain' ],
        'string',
        'min' => 4,
        'max' => 255,
        'when' => self::SCENARIO_APP_SETUP
      ]
    ];
  }
}
?>
