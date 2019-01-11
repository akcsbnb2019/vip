<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "zm_uprid".
 *
 * @property string $id
 * @property string $loginname
 * @property string $currid
 * @property string $newrid
 * @property string $uptime
 * @property integer $types
 */
class ZmUprid extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zm_uprid';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uptime'], 'safe'],
            [['types'], 'integer'],
            [['loginname', 'currid', 'newrid'], 'string', 'max' => 50],
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
            'currid' => 'Currid',
            'newrid' => 'Newrid',
            'uptime' => 'Uptime',
            'types' => 'Types',
        ];
    }
}
