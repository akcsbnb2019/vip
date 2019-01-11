<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "zm_fuxiao".
 *
 * @property string $id
 * @property string $userid
 * @property string $amount
 * @property string $addtime
 * @property integer $status
 * @property integer $scount
 */
class ZmFuxiao extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zm_fuxiao';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'addtime', 'status', 'scount'], 'integer'],
            [['amount'], 'required'],
            [['amount'], 'number'],
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
            'addtime' => 'Addtime',
            'status' => 'Status',
            'scount' => 'Scount',
        ];
    }
}
