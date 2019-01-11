<?php
namespace backend\controllers;

use Yii;
use backend\models\AdUser;
use common\models\User;
use yii\data\Pagination;
use backend\models\VipGroup;

/**
 * 代理商管理控制器
 */
class ProxyController extends BaseController
{
    /**
     * 列表
     * 
     * @return string
     */
    public function actionIndex($limit = 0, $count = 0)
    {
        $rs    = Yii::$app->request;
        $user  = new User();
        $where = $user->find()->where(['>','states',-1])->andWhere(['>','dllevel',0])->andWhere(['bd'=>1]);
        
        /* 模糊查询 用户名&姓名 */
        if($rs->post('s')){
            $name     = $rs->post('s');
            $truename = preg_match("/^[\x{4e00}-\x{9fa5}]+$/u",$name) ? $name : false;
            
            if(!$truename && preg_match("/^[\x{4e00}-\x{9fa5}]+/u",$name,$truename)){
                $truename = implode('', $truename);
            }
            $name = str_replace($truename, '', $name);
            
            if($truename){
                $where->andWhere(" truename = :truename ",[':truename'=>$truename]);
            }
            if(!empty($name)){
                $where->andWhere(" loginname like :loginname ",[':loginname'=>"%$name%"]);
            }
        }
        
        /* 时间条件 */
        if($rs->post('addtime')){
            $where->andWhere(" jihuotime >= :jihuotime ",[':jihuotime'=>$rs->post('addtime')]);
        }
        if($rs->post('endtime')){
            $where->andWhere(" jihuotime <= :jihuotime ",[':jihuotime'=>$rs->post('endtime')]);
        }
        
        /* 分页设置 &每页显示多少条*/
        $page  = new Pagination([
            'totalCount' => (AJAX && $count ? $rs->post('count') : $where->count()),
        ]);
        $page->defaultPageSize = intval($limit)<10?10:($limit>30?30:intval($limit));
        $model = $where->select(['id','loginname','standardlevel','amount','rid','pid','truename','bank','bankno','jihuotime','lockuser','bd','dllevel'])
                ->orderBy('id desc')->offset($page->offset)->limit($page->limit)->asArray()->all();
        $page->params=array("list"=>'all');
        
        if(AJAX){
            $this->layout = 'kong';
            return [
                'html' => $this->render('list',[
                    'model' => $model,
                ]),
                'page' => $page ,
            ];
        }else{
            $this->layout = 'layui2';
            return $this->render('index',[
                'model' => $model,
                'page' => $page,
            ]);
        }
    }
    
    /**
     * add 明前没有添加功能
     * 
     * @return string
     */
    public function actionAdd()
    {
        return $this->actionIndex();
    }
    
    /**
     * edit 编辑
     * 
     * @return string
     */
    public function actionEdit($id = 0)
    {
        /* 执行更新操作 */
        if(Yii::$app->request->isAjax){
        
            $modobj = new AdUser();
            $modobj->kong = false;
            $pUser = Yii::$app->request->post('AdUser');
            /** 日志*/
            self::$logobj['desc'] = 'id:'.intval($pUser['id']);
        
            /* 验证提交信息是否完整 */
            if (!$modobj->load(Yii::$app->request->post()) ) {
                return ['s'=>0,'m'=>'提交信息缺失！'];
            }
            /* 自定义过滤 */
            if(!$modobj->validate()){
                $err = $modobj->getErrors();
                list($first_key, $first) = (reset($err) ? each($err) : each($err));
                return ['s'=>0,'m'=>$first['0']];
            }
            /* 定义非己重复 */
            if($modobj->find()->where(['username'=>$pUser['username']])->andWhere(['NOT', ['id' => $pUser['id']]])->count()){
                return ['s'=>0,'m'=>'名称的值"'.$pUser['username'].'"已经被占用了。'];
            }
        
            /* 提交定义 */
            $update = $modobj->findOne($pUser['id']);
            foreach ($update as $k => $v){
                if(isset($pUser[$k]) && $v != $pUser[$k] && $pUser[$k] != ''){
                    if($k == 'password'){
                        $update->$k = md5($pUser[$k]);
                    }else{
                        $update->$k = $pUser[$k];
                    }
                }
            }
            if($update->save()){
                return ['s'=>1,'m'=>'提交成功','u'=>$this->urlTo('/'.THISID.'/index')];
            }
            return ['s'=>1,'m'=>'更新失败'];
        }
        
        if(!$id){
            return $this->goBack($this->urlTo('/'.THISID.'/index'));
        }pe($id);
        
        /* 取值 */
        $modobj = new AdUser();
        $data = $modobj->findOne(['id'=>intval($id)]);
        if(!$data){
            return $this->goBack($this->urlTo('/'.THISID.'/index'));
        }
        /* 取角色 */
        $group = new VipGroup();
        
        /* 初始化类型 */
        return $this->render('edit',[
            'data' => $data,
            'group' => $group->findOne(['id'=>$data['groupid']]),
        ]);
    }
    
    /**
     * up status 状态编辑 - 不执行删除
     * 
     * @return string
     */
    public function actionUpstatus()
    {
        /* 验证信息 */
        if(!Yii::$app->request->post('ids')){
            return ['s'=>0,'m'=>'没有可操作项'];
        }
        $ids = explode(',', Yii::$app->request->post('ids'));
        foreach ($ids as $k => $v){
            $ids[$k] = intval($v);
        }
        /** 日志*/
        self::$logobj['desc'] = 'id:'.implode(',', $ids);
        $status = Yii::$app->request->post('status');
        $modobj = new User();
        if($modobj->updateAll(['lockuser' => ($status == '-1'?1:intval($status))],['id' => $ids])){
            return ['s'=>1,'m'=>'编辑成功'];
        }
        return ['s'=>0,'m'=>'编辑失败！'];
    }
}
