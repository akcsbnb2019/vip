<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "income".
 *
 * @property integer $id
 * @property string $userid
 * @property string $types
 * @property string $amount
 * @property string $nowamount
 * @property string $adddate
 * @property string $addtime
 * @property string $reason
 */
class Performancem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'income';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amount', 'nowamount'], 'number'],
            [['adddate', 'addtime'], 'safe'],
            [['userid', 'types', 'reason'], 'string', 'max' => 50],
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
            'types' => 'Types',
            'amount' => 'Amount',
            'nowamount' => 'Nowamount',
            'adddate' => 'Adddate',
            'addtime' => 'Addtime',
            'reason' => 'Reason',
        ];
    }
}
