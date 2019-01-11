<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class VipLogin extends Model
{
    public $username;
    public $password;
    public $code;
    public $rememberMe = true;

    private $_user;
    public $isuser = false;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password','code'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
            'code' => '验证码',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = UserAdmin::findByUsername($this->username);
            if($this->_user !== null){
                $this->isuser = true;
            }
        }

        return $this->_user;
    }
    
    /**
     * 登录写入session
     *
     * @return User|null
     */
    public function setSession()
    {
        /* 获取用户基本信息 */
        $data = UserAdmin::findIdentity(Yii::$app->session->get("__id"));
        /* 指定key */
        $key  = [
            'uname' => 'username',
            'gid'   => 'groupid',
        ];
        
        /* 存储 */
        Yii::$app->session->set('uip',Yii::$app->request->userIP);
        foreach ($key as $k => $v){
            if(isset($data[$v])){
                Yii::$app->session->set($k,$data[$v]);
            }
        }
    }
}
