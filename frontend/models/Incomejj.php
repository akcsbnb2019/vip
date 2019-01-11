<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "incomejj".
 *
 * @property integer $id
 * @property string $userid
 * @property string $adddate
 */
class Incomejj extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'incomejj';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid'], 'required'],
            [['adddate'], 'safe'],
            [['userid'], 'string', 'max' => 50],
            ['adddate', 'default', 'value' => date("Y-m-d H:i:s",time())],
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
        ];
    }
    
    /**
     * 写入当天积分操作记录
     * @param unknown $userid
     * @return boolean
     */
    public function addIncomejj($userid){
        $count    = $this->find()->where('userid=:userid',[':userid'=>$userid])->andWhere(['adddate'=>date("Y-m-d",time())])->count();
        $this->userid = $userid;
        if($count != 0 || $this->save()){
            return true;
        }
        return false;
    }
}
