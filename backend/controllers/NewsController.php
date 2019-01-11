<?php
namespace backend\controllers;

use Yii;
use backend\models\News;
use yii\data\Pagination;

/**
 * 新闻管理控制器
 */
class NewsController extends BaseController
{
    /**
     * 列表
     * 
     * @return string
     */
    public function actionIndex($limit = 0, $count = 0)
    {
        $title  = Yii::$app->request->post('s');
        $modobj = new News();
        $where  = $modobj->find()->andWhere(['>','status',-1]);
        
        /* 模糊查询 */
        if($title){
            $where->andWhere(" title like :title ",[':title'=>"%$title%"]);
        }
        
        /* 优化记录数求和 */
        $page  = new Pagination([
            'totalCount' => (AJAX && $count ? Yii::$app->request->post('count') : $where->count()),
        ]);
        $page->defaultPageSize = intval($limit)<10?10:(intval($limit)>30?30:intval($limit));
        $data = $where->orderBy('ArticleID DESC')->offset($page->offset)->limit($page->limit)->asArray()->select('ArticleID,title,UpdateTime,status')->all();
        
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
            /** 日志*/
            self::$logobj['desc'] = 'id:';
            $News   = Yii::$app->request->post('News');
            $keys   = ['UpdateTime', 'BegindateTime', 'EnddateTime'];
            $modobj = new News();
            $keyN   = $modobj->attributeLabels();
            
            /* 验证输入时间格式是否合法 */
            foreach ($keys as $name){
                if(!strtotime($News[$name])){
                    return ['s'=>0,'m'=>$keyN[$name].'格式非法！'];
                    break;
                }
            }
            
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
        
        /* 初始化类型 */
        $this->layout = 'layui2';
        return $this->render('add',[
            'uptime' => date('Y-m-d',time()),
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
            $News   = Yii::$app->request->post('News');
            $keys   = ['UpdateTime', 'BegindateTime', 'EnddateTime'];
            $modobj = new News();
            $keyN   = $modobj->attributeLabels();
            /** 日志*/
            self::$logobj['desc'] = 'id:'.intval($News['ArticleID']);
            
            /* 验证输入时间格式是否合法 */
            foreach ($keys as $name){
                if(!strtotime($News[$name])){
                    return ['s'=>0,'m'=>$keyN[$name].'格式非法！'];
                    break;
                }
            }
        
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
        
            /* 提交定义 */
            $update = $modobj->findOne(self::intset($News['ArticleID']));
            if($update){
                foreach ($update as $k => $v){
                    if(isset($News[$k]) && $v != $News[$k] && $News[$k] != ''){
                        $update->$k = $News[$k];
                    }
                }
                if($update->save()){
                    return ['s'=>1,'m'=>'提交成功','u'=>$this->urlTo('/'.THISID.'/index')];
                }
            }
            
            return ['s'=>0,'m'=>'更新失败'];
        }
        
        if(!$id){
            return $this->goBack($this->urlTo('/'.THISID.'/index'));
        }
        
        /* 取值 */
        $modobj = new News();
        $data = $modobj->findOne(['ArticleID'=>intval($id)]);
        if(!$data){
            return $this->goBack($this->urlTo('/'.THISID.'/index'));
        }
        
        /* 初始化类型 */
        $this->layout = 'layui2';
        return $this->render('edit',[
            'data'    => $data,
            'content' => str_replace("'","&#39;", $data['content']),
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
        $modobj = new News();
        if($modobj->updateAll(['status' => intval(Yii::$app->request->post('status'))],['ArticleID' => $ids])){
            return ['s'=>1,'m'=>'编辑成功'];
        }
        return ['s'=>0,'m'=>'编辑失败！'];
    }
}
