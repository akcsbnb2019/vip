<?php
namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use backend\models\AdUser;

/**
 * 默认控制器
 */
class PublicController extends BaseController
{
    /**
     * @继承doc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @继承doc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captchatest' => [
                'class' => 'yii\captcha\CaptchaAction',
                'maxLength' => 4, //生成的验证码最大长度
                'minLength' => 4  //生成的验证码最短长度
            ]
        ];
    }
    
    /**
     * 登录页面
     * 
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'null';
        return $this->render('index');
    }
    
    /**
     * 登录验证
     * 
     * @return string
     */
    public function actionLogin()
    {
        if(Yii::$app->request->isAjax){
            
            $post = Yii::$app->request->post();
            
            $post['name'] = $this->strSafety($post['name']);
            
            /* 验证 账号参数 */
            if(empty($post['name'])){
                return ['s'=>0,'m'=>'用户名为空！'];
            }else if(mb_strlen($post['name'],'UTF8') < 4 || mb_strlen($post['name'],'UTF8') > 11){
                return ['s'=>0,'m'=>'用户名格式错误！'];
            }else if(empty($post['password'])){
                return ['s'=>0,'m'=>'密码为空！'];
            }else if(empty($post['code'])){
                return ['s'=>0,'m'=>'请输入验证码！'];
            }else if(strlen($post['code']) != 4){
                return ['s'=>0,'m'=>'验证码格式错误！'];
            }
            
            /* 验证码 */
            if(!$this->createAction('captchatest')->validate($post['code'], false)){
                return ['s'=>0,'m'=>'验证码错误！'];
            }
            
            $m = new AdUser();
            $user = $m->getOne($post['name']);
            
            if(!$user){
                return ['s'=>0,'m'=>'账号不存在'];
            }
            if($user['password'] == md5($post['password'])){
                Yii::$app->session->set('uid',$user['id']);
                Yii::$app->session->set('uname',$user['username']);
                Yii::$app->session->set('gid',$user['groupid']);
                Yii::$app->session->set('uip',Yii::$app->request->userIP);
                return ['s'=>1,'m'=>'登录成功','u'=>$this->urlTo('/site/index')];
            }
            return ['s'=>0,'m'=>'密码错误'];
        }
    }
}
