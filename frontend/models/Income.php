<?php

namespace frontend\models;

use Yii;
use frontend\models\Incomejj;

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
class Income extends \yii\db\ActiveRecord
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
            ['reason', 'default', 'value' => Yii::$app->session->get('loginname')],
            ['addtime', 'default', 'value' => date("Y-m-d H:i:s",time())],
            ['adddate', 'default', 'value' => date("Y-m-d",time())],
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

    /*
     * 获取个人所得奖金
     * 参数: $loginname  用户名
     *       $addtime    注册时间
     */
    public function getAmountall(){
        $data = $this->find()->select("sum(amount) as amount")
        ->where(['userid'=>Yii::$app->session->get("loginname"),'types' => ['销售积分','管理积分','绩效积分','邀请积分']])
        ->andWhere(['>','addtime',Yii::$app->session->get("addtime")])->asArray()->one();
        return empty($data['amount']) ? 0 : $data['amount'];
    }
    /*
     * 获取个人所得代理费
     * 参数: $loginname  用户名
     *       $addtime    注册时间
     */
    public function getDlAmount(){

        $data = $this->find()->select("sum(amount) as amount")
                ->where(['userid'=>Yii::$app->session->get("loginname"),'types' => ['代理费']])
                ->andWhere(['>','addtime',Yii::$app->session->get("addtime")])->asArray()->one();
        
        return $data['amount'] < 0 ? 0 : $data['amount'];
    }
    
    /**
     * 
     * 获取个人所得代理费
     * 参数: $loginname  用户名
     *       $addtime    注册时间
     * @param unknown $userid
     * @param unknown $amount
     * @param unknown $types
     * @param unknown $nowamount
     * @param string $injj 非绩效统计项不触发记录
     */
    public function addIncome($userid,$amount,$types,$nowamount,$injj = true,$reason = ''){
        $this->userid    = $userid;
        $this->amount    = $amount;
        $this->types     = $types;
        $this->nowamount = $nowamount;
        if(!empty($reason)){
            $this->reason    =$reason;
        }
        if($injj){
            $Incomejj        = new Incomejj();
            if($Incomejj->addIncomejj($userid) && $this->save()){
                return true;
            }
        }else if( $this->save()){
            return true;
        }
        
        return false;
    }
}
