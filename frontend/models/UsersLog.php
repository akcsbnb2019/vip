<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "users_log".
 *
 * @property integer $id
 * @property string $uname
 * @property string $msg
 * @property string $ip
 * @property string $date
 * @property integer $types
 */
class UsersLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip', 'date'], 'required'],
            [['date'], 'safe'],
            [['types'], 'integer'],
            [['uname'], 'string', 'max' => 64],
            [['msg', 'ip'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uname' => 'Uname',
            'msg' => 'Msg',
            'ip' => 'Ip',
            'date' => 'Date',
            'types' => 'Types',
        ];
    }
    
    public function loginLog($uname,$msg,$ip){
        $this->uname = $uname;
        $this->msg = $msg;
        $this->ip = $ip;
        $this->date = date("Y-m-d H:i:s",time());
        $this->types = 0;
        return $this->save();
    }
}
