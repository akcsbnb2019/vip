<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "adhgfqws65ljdlgr".
 *
 * @property integer $ID
 * @property string $username
 * @property string $realname
 * @property string $password
 * @property string $LastLoginIP
 * @property string $LastLoginTime
 * @property string $permission
 */
class AdUser extends \yii\db\ActiveRecord
{
    public $kong = true;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'adhgfqws65ljdlgr';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $r = [
            [['username'], 'required'],
            [['LastLoginTime'], 'safe'],
            [['permission','groupid', 'sort', 'status'], 'integer'],
            [['username', 'realname', 'password', 'LastLoginIP'], 'string', 'max' => 50],
        ];
        
        if($this->kong){
            $r['aduser'] = ['username', 'unique'];
        }
        return $r;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'realname' => 'Realname',
            'password' => '密码',
            'LastLoginIP' => '最后登录Ip',
            'LastLoginTime' => '最后登录时间',
            'permission' => 'Permission',
            'groupid' => '角色',
            'status' => '状态',
            'sort' => '排序',
        ];
    }
    /**
     * 获取后台用户
     * @param unknown $name
     */
    public function getOne($name)
    {
        return $this->findOne(['username'=>$name]);
    }
    
}
