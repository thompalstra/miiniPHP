<?php
namespace mii\installation\models;
class MiiConfig extends \mii\base\Model{

  const SCENARIO_STEP_ONE = 's1';
  const SCENARIO_STEP_TWO = 's2';

  public $db_host = 'localhost';
  public $db_name = 'project';
  public $db_user = 'root';
  public $app_name = 'Project';
  public $app_prefix = 'project_';

  public $username = 'admin';
  public $password = 'admin';

  public function rules(){
    return [
      [ [ 'db_host', 'db_name', 'db_user',
      'app_name', 'app_prefix' ],
        'required',
        'when' => self::SCENARIO_STEP_ONE
      ],
      [ [ 'db_password' ],
        'safe',
        'when' => self::SCENARIO_STEP_ONE
      ],
      [ [ 'username', 'password' ],
        'string',
        'min' => 4,
        'max' => 255,
        'when' => self::SCENARIO_STEP_TWO
      ]
    ];
  }
}
?>
