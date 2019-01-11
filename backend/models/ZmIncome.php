<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "zm_income".
 *
 * @property string $id
 * @property string $userid
 * @property string $amount
 * @property string $balance
 * @property string $addtime
 * @property string $reason
 * @property integer $types
 */
class ZmIncome extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zm_income';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'reason', 'types'], 'integer'],
            [['amount', 'balance'], 'number'],
            [['addtime'], 'safe'],
            [['remark'], 'string', 'max' => 255],
            ['addtime', 'default', 'value' => date("Y-m-d H:i:s",time())],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => '用户编号',
            'remark' => '说明',
            'amount' => '变动积分',
            'balance' => '变动后余额',
            'addtime' => '添加时间',
            'reason' => '来源用户或目标',
            'types' => '类型',
        ];
    }

    /**
     *
     * 获取个人所得代理费
     * 参数: $loginname  用户名
     *       $addtime    注册时间
     * @param unknown $userid
     * @param unknown $amount
     * @param unknown $balance
     * @param unknown $types
     * @param number $reason
     * @return boolean
     */
    public function addIncome($userid,$amount,$balance,$types,$reason = 0){
        $this->userid    = $userid;
        $this->amount    = $amount;
        $this->balance   = $balance;
        $this->reason    = $reason;
        $this->types     = $types;
        
        if($this->save()){
            return true;
        }
        return false;
    }
}
