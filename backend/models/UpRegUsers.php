<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "up_reg_users".
 *
 * @property string $id
 * @property string $loginname
 * @property integer $standardlevel
 * @property integer $types
 * @property integer $up_standardlevel
 * @property string $addtime
 * @property string $admin_name
 * @property string $luname
 * @property string $runame
 */
class UpRegUsers extends \yii\db\ActiveRecord
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
            [['loginname', 'admin_name', 'luname', 'runame'], 'string', 'max' => 255],
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
            'types' => 'Types',
            'up_standardlevel' => 'Up Standardlevel',
            'addtime' => 'Addtime',
            'admin_name' => 'Admin Name',
            'luname' => 'Luname',
            'runame' => 'Runame',
        ];
    }
}
