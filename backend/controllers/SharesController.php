<?php
namespace backend\controllers;

use Yii;
use backend\models\AdUser;
use backend\models\Stocks;
use backend\models\VipGroup;
use yii\data\Pagination;

/**
 * 股份分红颁发
 */
class SharesController extends BaseController
{    
    /**
     * 列表
     * 
     * @return string
     */
    public function actionIndex($limit = 0, $count = 0)
    {
        $modobj = new Stocks();
        $where = $modobj->find();
        
        /* 模糊查询 */
        if(Yii::$app->request->post('s')){
            $where->andWhere(['like', 'username', Yii::$app->request->post('s')]);
        }

        $page  = new Pagination([
            'totalCount' => (AJAX && $count ? Yii::$app->request->post('count') : $where->count()),
        ]);
        $page->defaultPageSize = intval($limit)<10?10:(intval($limit)>30?30:intval($limit));
        $data = $where->orderBy('id DESC')->offset($page->offset)->limit($page->limit)->asArray()->all();

        if(AJAX){
            $this->layout = 'kong';
            return [
                'html' => $this->render('list',[
                    'model' => $data,
                ]),
                'page' => $page ,
            ];
        }else{
            $this->layout = 'layui2';
            return $this->render('index',[
                'model' => $data,
                'page'  => $page,
            ]);
        }

    }
    
    /**
     * add 添加
     * 
     * @return string
     */
    public function actionAdd()
    {
        /* 执行更新操作 */
        if(Yii::$app->request->isAjax){
            $modobj = new AdUser();
            /** 日志*/
            self::$logobj['desc'] = 'id:';
            /* 验证提交信息是否完整 */
            if (!$modobj->load(Yii::$app->request->post()) ) {
                return ['s'=>0,'m'=>'提交信息缺失！'];
            }
            if(!$modobj->save()){
                $err = $modobj->getErrors();
                list($first_key, $first) = (reset($err) ? each($err) : each($err));
                return ['s'=>0,'m'=>$first['0']];
            }
            self::$logobj['desc'] .= Yii::$app->db->getLastInsertId();
            return ['s'=>1,'m'=>'提交成功','u'=>$this->urlTo('/'.THISID.'/index')];
        }
        
        $modobj2 = new VipGroup();
        $data = $modobj2->find()->andWhere(['>','status',0])->select('id,name')->orderBy('sort DESC,id DESC')->all();
        
        /* 初始化类型 */
        return $this->render('add',[
            'data' => $data,
        ]);
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
        }
        
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
     * up status 状态编辑&删除
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
        $modobj = new AdUser();
        if($modobj->updateAll(['status' => intval(Yii::$app->request->post('status'))],['id' => $ids])){
            return ['s'=>1,'m'=>'编辑成功'];
        }
        return ['s'=>0,'m'=>'编辑失败！'];
    }
}
