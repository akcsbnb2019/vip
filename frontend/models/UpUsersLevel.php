<?php

namespace frontend\models;

use Yii;

/**
 * 会员升级记录表
 *
 * @property string $id
 * @property string $loginname
 * @property integer $standardlevel
 * @property integer $newstandardlevel
 * @property integer $up_standardlevel
 * @property integer $up_newstandardlevel
 * @property string $addtime
 * @property string $admin_name
 */
class UpUsersLevel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'up_reg_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['standardlevel', 'types', 'up_standardlevel'], 'integer'],
            [['addtime'], 'safe'],
            [['loginname', 'admin_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'loginname' => 'Loginname',
            'standardlevel' => 'Standardlevel',
            'types' => 'types',
            'up_standardlevel' => 'Up Standardlevel',
            'addtime' => 'Addtime',
            'admin_name' => 'Admin Name',
            'luname' => 'luname',
            'runame' => 'runame',
        ];
    }
	
	public function addlevel($loginname,$level,$newvip,$types=0,$luname="",$runame="")
	{
		$this->loginname = $loginname;
		$this->standardlevel = $level;
		$this->types = $types;
		$this->up_standardlevel = $newvip;
		$this->addtime = date("Y-m-d H:i:s",time());;
		$this->admin_name = $loginname;
		$this->luname = $luname;
		$this->runame = $runame;
		if(!$this->save()){
			$err = $this->getErrors();
			list($first_key, $first) = (reset($err) ? each($err) : each($err));
			return $first['0'];
		}
		return true;
	}
 
 
 
}
