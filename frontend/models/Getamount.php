<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "getamount".
 *
 * @property integer $id
 * @property string $userid
 * @property string $amount
 * @property string $bank
 * @property string $bankno
 * @property string $bankuser
 * @property string $addtimes
 * @property string $memo
 * @property integer $states
 * @property string $get_amount
 */
class Getamount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'getamount';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid','amount'], 'required'],
            [['amount', 'get_amount'], 'number'],
            [['addtimes'], 'safe'],
            [['states'], 'integer'],
            [['userid', 'bankno'], 'string', 'max' => 35],
            [['bank', 'bankuser', 'memo'], 'string', 'max' => 20],
            [['amount'],'match','pattern'=>"/^\d*[50]+0$/u",'message'=>"金额必须是50的倍数"],
            [['userid', 'bankno'],'match', 'pattern'=>"/^[a-zA-Z\d_.]+$/u", 'message'=>'会员名无效，格式错误'],
            [['bank', 'bankuser', 'memo'],'match', 'pattern'=>"/^[ ，。（）“”？0-9A-Za-z_\x{4e00}-\x{9fa5}.]+$/u", 'message'=>'请输入文字及中文标点符号，”逗号“、”句号“！'],
            ['userid', 'default', 'value' => Yii::$app->session->get('loginname')],
            ['addtimes', 'default', 'value' => date("Y-m-d H:i:s",time())],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'userid' => '用户名',
            'amount' => '兑换积分',
            'bank' => '所属银行',
            'bankno' => '银行帐号',
            'bankuser' => '开户姓名',
            'addtimes' => '时间',
            'memo' => '备注说明',
            'states' => '兑换类型',
            'get_amount' => '到账金额',
        ];
    }
}
