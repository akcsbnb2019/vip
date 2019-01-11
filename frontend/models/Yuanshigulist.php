<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "yuanshigulist".
 *
 * @property string $id
 * @property string $loginname
 * @property string $yuanshigu
 * @property string $aixinyuanshigu
 * @property string $jiangliyuanshigu
 * @property string $goumaiyuanshigu
 */
class Yuanshigulist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yuanshigulist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['yuanshigu', 'aixinyuanshigu', 'jiangliyuanshigu', 'goumaiyuanshigu'], 'number'],
            [['loginname'], 'string', 'max' => 255],
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
            'yuanshigu' => 'Yuanshigu',
            'aixinyuanshigu' => 'Aixinyuanshigu',
            'jiangliyuanshigu' => 'Jiangliyuanshigu',
            'goumaiyuanshigu' => 'Goumaiyuanshigu',
        ];
    }
}
