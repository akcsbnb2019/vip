<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "u_jiangli".
 *
 * @property integer $id
 * @property string $username
 * @property string $bcstock
 * @property string $yystock
 * @property string $zong
 * @property string $adddate
 * @property string $addtime
 */
class UJiangli extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'u_jiangli';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'bcstock', 'yystock', 'zong', 'adddate', 'addtime'], 'required'],
            [['bcstock', 'yystock', 'zong'], 'number'],
            [['adddate', 'addtime'], 'safe'],
            [['username'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'bcstock' => 'Bcstock',
            'yystock' => 'Yystock',
            'zong' => 'Zong',
            'adddate' => 'Adddate',
            'addtime' => 'Addtime',
        ];
    }
}
