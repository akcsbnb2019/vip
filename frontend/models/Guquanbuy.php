<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "guquanbuy".
 *
 * @property integer $id
 * @property string $userid
 * @property integer $amount
 * @property string $addtimes
 * @property integer $states
 */
class Guquanbuy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'guquanbuy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amount', 'states'], 'integer'],
            [['addtimes'], 'safe'],
            [['userid'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => 'Userid',
            'amount' => '兑换福利积分',
            'addtimes' => 'Addtimes',
            'states' => 'States',
        ];
    }
}
