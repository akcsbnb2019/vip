<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "ma_change_money".
 *
 * @property int $id
 * @property string $send_userid
 * @property string $to_userid
 * @property string $money
 * @property string $change_time
 * @property string $why_change
 * @property int $types
 * @property string $give_money
 * @property string $amount
 * @property string $flag
 */
class ChangeMoney extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'change_money';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    { 
        return [
            [['send_userid'], 'required'],
            [['money', 'give_money', 'amount'], 'number'],
            [['change_time'], 'safe'],
            [['types', 'flag'], 'integer'],
            [['send_userid', 'to_userid', 'why_change'], 'string', 'max' => 50]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'send_userid' => 'Send Userid',
            'to_userid' => 'To Userid',
            'money' => 'Money',
            'change_time' => 'Change Time',
            'why_change' => 'Why Change',
            'types' => 'Types',
            'give_money' => 'Give Money',
            'amount' => 'Amount',
            'flag' => 'Flag',
        ];
    }
}
