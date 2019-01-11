<?php
namespace common\models;

use Yii;
use yii\base\Model;
use frontend\models\ZmPosition;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
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
            $pos = ZmPosition::findOne(['uname'=>$this->username]);
            if(empty($pos) || $pos === false){
                return false;
            }
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600  : 0);
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
            $this->_user = User::findByUsername($this->username);
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
        $data = User::findIdentity(Yii::$app->user->id);
        /* 指定key */
        $key  = [
            'loginname' => 'loginname',
            'level' => 'standardlevel',
            'addtime' => 'addtime',
            'jihuotime' => 'jihuotime',
        ];
        
        /* 存储 */
        Yii::$app->session->set('uip',Yii::$app->request->userIP);
        foreach ($key as $k => $v){
            if(isset($data[$v])){
                Yii::$app->session->set($k,$data[$v]);
            }
        }
        /* 安全初始化项 */
        if(empty($data['identityid'])){
            Yii::$app->session->set('sid',1);
        }
        if(empty($data['pwd2'])){
            Yii::$app->session->set('spwd',1);
        }
    }
}
