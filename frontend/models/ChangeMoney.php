<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "change_money".
 *
 * @property integer $id
 * @property string $send_userid
 * @property string $to_userid
 * @property string $money
 * @property string $change_time
 * @property string $why_change
 * @property integer $types
 */
class ChangeMoney extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'change_money';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['money'], 'required'],
            [['money'], 'number'],
            [['change_time'], 'safe'],
            [['types'], 'integer'],
            [['send_userid', 'to_userid'], 'string', 'max' => 35],
            ['why_change', 'string', 'max' => 20],
            [['to_userid','send_userid'],'match', 'pattern'=>"/^[a-zA-Z\\d_.]+$/u", 'message'=>'会员名无效，格式错误！'],
            [['money'],'match','pattern'=>"/^\d*[50]+0$/u",'message'=>"金额必须是50的倍数"],
            ['why_change','match', 'pattern'=>"/^[ ，。（）“”？0-9A-Za-z_\\x{4e00}-\\x{9fa5}.]+$/u", 'message'=>'请输入文字及中文标点符号，”逗号“。”句号“”引号！'],
            ['send_userid', 'default', 'value' => Yii::$app->session->get('loginname')],
            ['change_time', 'default', 'value' => date("Y-m-d H:i:s",time())],
            ['types', 'default', 'value' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'send_userid' => '转账用户',
            'to_userid' => '接收会员',
            'money' => '转账积分',
            'change_time' => '转账时间',
            'why_change' => '转账说明',
            'types' => '类型',
        ];
    }
}
