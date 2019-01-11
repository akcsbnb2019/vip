<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "zm_tdgjj".
 *
 * @property string $id
 * @property string $userid
 * @property string $points
 * @property string $pre
 * @property string $bonus
 * @property integer $orderid
 * @property string $reason
 * @property integer $type
 * @property string $addtime
 * @property integer $status
 * @property string $declaration
 */
class ZmTdgjj extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zm_tdgjj';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'orderid', 'reason', 'type', 'addtime', 'status', 'declaration'], 'integer'],
            [['points'], 'required'],
            [['points', 'pre', 'bonus'], 'number'],
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
            'points' => 'Points',
            'pre' => 'Pre',
            'bonus' => 'Bonus',
            'orderid' => 'Orderid',
            'reason' => 'Reason',
            'type' => 'Type',
            'addtime' => 'Addtime',
            'status' => 'Status',
            'declaration' => 'Declaration',
        ];
    }
}
