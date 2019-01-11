<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "zm_travel".
 *
 * @property string $id
 * @property string $userid
 * @property string $points
 * @property integer $orderid
 * @property string $reason
 * @property string $addtime
 * @property integer $status
 */
class ZmTravel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zm_travel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'orderid', 'reason', 'addtime', 'status'], 'integer'],
            [['points'], 'required'],
            [['points'], 'number'],
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
            'orderid' => 'Orderid',
            'reason' => 'Reason',
            'addtime' => 'Addtime',
            'status' => 'Status',
        ];
    }
}
