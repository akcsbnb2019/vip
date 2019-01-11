<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "zm_lovefund".
 *
 * @property string $id
 * @property string $userid
 * @property string $amount
 * @property string $love
 * @property integer $orderid
 * @property string $reason
 * @property string $addtime
 * @property integer $status
 */
class ZmLovefund extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zm_lovefund';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'orderid', 'reason', 'addtime', 'status'], 'integer'],
            [['amount'], 'required'],
            [['amount', 'love'], 'number'],
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
            'amount' => 'Amount',
            'love' => 'Love',
            'orderid' => 'Orderid',
            'reason' => 'Reason',
            'addtime' => 'Addtime',
            'status' => 'Status',
        ];
    }
}
