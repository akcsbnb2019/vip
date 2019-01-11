<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "zm_report".
 *
 * @property integer $id
 * @property string $userid
 * @property string $adddate
 * @property integer $status
 * @property string $readddate
 * @property string $readdtime
 */
class ZmReport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zm_report';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['adddate', 'readddate', 'readdtime'], 'safe'],
            [[ 'district', 'city','province','tel'], 'required'],
            [['status'], 'integer'],
            [['userid'], 'string', 'max' => 255],
            ['tel','match', 'pattern'=>"/^1[3,4,5,6,7,8,9]{1}[\d]{9}$/u", 'message'=> '{attribute}格式错误，请重新输入！'],
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
            'adddate' => 'Adddate',
            'status' => 'Status',
            'readddate' => 'Readddate',
            'readdtime' => 'Readdtime',
            'district' => '地区',
            'tel'=>'手机'
        ];
    }
}
