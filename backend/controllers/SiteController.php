<?php
namespace backend\controllers;

use Yii;
use common\models\VipLogin;

/**
 * 默认控制器
 */
class SiteController extends BaseController
{

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
        return $this->actionLogin();
    }
    
    /**
     * 登录验证
     * 
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $model = new VipLogin();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';
            $this->layout = 'null';
        
            return $this->render('login', [
                'model' => $model
            ]);
        }
    }
    
    public function actionLajax()
    {
        if(Yii::$app->request->isAjax){
            $post = Yii::$app->request->post();
            self::$logobj['desc'] = 'login';
        
            /* 验证码 */
            if(!$this->createAction('captchatest')->validate($post['VipLogin']['code'], false)){
                return ['status'=>2,'msg'=>'验证码错误！','id' => 'viplogin-code'];
            }
        
            $model = new VipLogin();
        
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                $model->setSession();
                self::$logobj['adminid'] = Yii::$app->session->get("__id");
                return ['status' => 1,'msg' => '登录成功！','url' => $this->urlTo('/index/index')];
            } else {
                if($model->isuser){
                    return ['status' => 2,'msg' => '密码错误！','id' => 'viplogin-password'];
                }else{
                    return ['status' => 2,'msg' => '用户名不存在！','id' => 'viplogin-username'];
                }
            }
        } else {
            return ['status' => 3,'msg' => '你想干啥!'];
        }

    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogouts()
    {
        Yii::$app->user->logout();

        return $this->goBack($this->urlTo('/site/login'));
    }
    
    /**
     * 默认友好页面
     * 
     * @return string
     */
    public function actionMain()
    {
        $this->layout = 'layui2';
        return $this->render('main',[
            'type' => 1
        ]);
    }
    
    /**
     * 默认登录友好页面
     * 
     * @return string
     */
    public function actionMains()
    {
        $this->layout = 'layui2';
        return $this->render('main',[
            'type' => 2
        ]);
    }
}