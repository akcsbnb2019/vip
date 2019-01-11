<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "zm_position_points".
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
 */
class ZmPositionPoints extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zm_position_points';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'orderid', 'reason', 'type', 'addtime', 'status'], 'integer'],
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
        ];
    }
}
