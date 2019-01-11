<?php

namespace backend\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user_backend".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 */
class UserBackend extends \yii\db\ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    public $kong = true;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zm_user_admin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {

        $r = [
            [['username'], 'required'],
            [['LastLoginTime'], 'safe'],
            [['permission', 'groupid', 'status', 'sort'], 'integer'],
            [['username', 'realname', 'password', 'LastLoginIP'], 'string', 'max' => 50],
            [[ 'password_hash'], 'string', 'max' => 255],
            [['auth_key', 'pass_hash', 'pass_token'], 'string', 'max' => 100],
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
            'realname' => '真实姓名',
            'password' => '密码',
            'LastLoginIP' => '最后登录Ip',
            'LastLoginTime' => '最后登录时间',
            'permission' => 'Permission',
            'groupid' => '角色',
            'status' => '状态',
            'sort' => '排序',
            'auth_key' => 'Auth Key',
            'pass_hash' => 'pass Hash',
            'pass_token' => 'Pass Token',
            'password_hash' => 'Password Hash',
        ];
    }

    // 其他gii生成的代码，因为我们并未对其进行过改动，因此这里省略，下面只补充我们实现的几个抽象方法

    /**
     * @inheritdoc
     * 根据user_backend表的主键（id）获取用户
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     * 根据access_token获取用户，我们暂时先不实现，我们在文章 http://www.manks.top/yii2-restful-api.html 有过实现，如果你感兴趣的话可以看看
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @inheritdoc
     * 用以标识 Yii::$app->user->id 的返回值
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     * 获取auth_key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     * 验证auth_key
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }
}
