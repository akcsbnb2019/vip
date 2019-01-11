<?php
namespace frontend\controllers;

use Yii;
use common\models\User;
use yii\data\Pagination;

/**
 * 图谱控制器
 */
class AtlasController extends BaseController
{
    /**
     * 邀请图谱
     * @param number $limit
     * @param number $count
     * @return number[]|string[]|string[]|\yii\data\Pagination[]|string
     */
    public function actionIndex($limit = 15, $count = 1000)
    {
        $post = Yii::$app->request->post('User');
        
        $user = new User();
        if(isset($post['loginname']) && !empty($post['loginname']) && preg_match("/^[a-z\\d]*$/", $post['loginname'], $toname)){
            $obj = $user->find()->where('loginname=:loginname',[':loginname' => implode(',', $toname)])
            ->andWhere('rid=:rid',[':rid'=>Yii::$app->session->get("loginname")]);
        }else{
            $rid = Yii::$app->session->get("loginname");
            if(isset($post['rid'])&&!empty($post['rid'])){
                $ruser = $user->findOne(['loginname'=>$post['rid']]);
                $arr   = explode(',',$ruser['rpath']);
                $rid   = $post['rid'];
                if(!in_array(UID,$arr)){
                    $rid = false;
                }
            }
            if($rid === false){
                $obj = $user->find()->where('rid=-1');
            }else{
                $obj = $user->find()->where('rid=:rid',[':rid'=>$rid]);
            }
        }
        
        /* 获取总记录数 */
        if(Yii::$app->request->post('count')){
            return [ 'count' => $obj->count() ];
        }
        $page  = new Pagination(['totalCount' => $obj->count()]);
        $page->defaultPageSize = $limit == 15?15:30;
        /* 默认显示停用，太慢 */
        $model = $obj->orderBy('id desc')->offset($page->offset)->select(['loginname','rid','pid','standardlevel','truename','tel','addtime'])->limit($page->limit)->asArray()->all();
        $page->params = ['list'=>'all'];
        if(Yii::$app->request->isAjax){
	        return [
                'html' => $this->render('inviteList',[
                    'model' => $model,
                ]), 
                'page' => $page,
                ];
        }else{
            return $this->render('invite',[ 'model' => $model, 'page' => $page, 'user' => $user]);
        }
    }

    /**
     * 会员图谱
     *
     * @return mixed
     */
    public function actionUser()
    {
        /* 登录验证 */
        if(!defined('UID')){
            return $this->msg('请登录!',['icon'=>0,'url'=>'/']);
        }
        /* 请求是否正常 */
        $id = Yii::$app->request->get('id',UID);
        $key= ['id','loginname','lallyeji','rallyeji','num1','num2','standardlevel','pay_points_all','ppath','area'];
        if($id != intval($id)){
            return $this->msg('异常请求!',['icon'=>0,'url'=>$this->urlTo('/atlas/user')]);
        }
        /* 条件设置,验证 */
        $post = Yii::$app->request->post('User');
        $user = new User();
        if(isset($post['loginname']) && !empty($post['loginname']) && preg_match("/^[a-z\\d]*$/", $post['loginname'], $toname)){
            $obj = $user->find()->where('loginname=:loginname',[':loginname'=>implode(',', $toname)]);
        }else{
            $obj = $user->find()->where(['id'=>intval($id)]);
        }
        $usero = $obj->select($key)->asArray()->one();
        if(!$usero){
            return $this->msg('您输入的用户不存在!',['icon'=>0,'url'=>$this->urlTo('/atlas/user')]);
        }
        $arr = explode(',',$usero['ppath']);
        if(UID!=$usero['id'] && !in_array(UID, $arr)) {
            return $this->msg('图谱中没有找到这个人!',['icon'=>0,'url'=>$this->urlTo('/atlas/user')]);
        }
        /* 查询子集 */
        $userp  = $user->find()->where('pid=:pid',[':pid'=>$usero['loginname']])->select($key)->asArray()->all();
        $model  = ['user' => $usero];
        foreach ($userp as $val){
            $model[($val['area'] == 1 ? 'left' : 'right')] = $val;
        }
        return $this->render('user',[
            'user' => $user,
            'model' => $model,
        ]);
    }
}
