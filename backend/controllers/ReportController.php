<?php
namespace backend\controllers;

use backend\models\Users;
use Yii;
use backend\models\ZmReport;
use backend\models\Region;
use yii\data\Pagination;

/**
 * 新闻管理控制器
 */
class ReportController extends BaseController
{
    /**
     * 列表
     * 
     * @return string
     */
    public function actionIndex($limit = 0, $count = 0)
    {
        $userid  = Yii::$app->request->post('s');
        $modobj = new ZmReport();
        $region = new Region();
        $re_row = $region->find()->select('region_id,region_name')->asArray()->all();
        $where  = $modobj->find();
        
        /* 模糊查询 */
        if($userid){
            $where->andWhere(" userid like :userid ",[':userid'=>"%$userid%"]);
        }
        
        /* 优化记录数求和 */
        $page  = new Pagination([
            'totalCount' => (AJAX && $count ? Yii::$app->request->post('count') : $where->count()),
        ]);
        $page->defaultPageSize = intval($limit)<10?10:(intval($limit)>30?30:intval($limit));
        $data = $where->orderBy('id DESC')->offset($page->offset)->limit($page->limit)->asArray()->all();
        if(!empty($data)){
            foreach ($data as $k=>$v){
                foreach ($re_row as $key =>$value){
                    if($v['province']==$value['region_id']){
                        $data[$k]['province'] = $value['region_name'];
                    }
                    if($v['city']==$value['region_id']){
                        $data[$k]['city'] = $value['region_name'];
                    }
                    if($v['district']==$value['region_id']){
                        $data[$k]['district'] = $value['region_name'];
                    }
                }
            }
        }
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
            
            $News   = Yii::$app->request->post('News');
            $keys   = ['UpdateTime', 'BegindateTime', 'EnddateTime'];
            $modobj = new ZmReport();
            $keyN   = $modobj->attributeLabels();
            /** 日志*/
            self::$logobj['desc'] = 'id:';
            
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
			echo 1;die;
            $News   = Yii::$app->request->post('News');
            $keys   = ['UpdateTime', 'BegindateTime', 'EnddateTime'];
            $modobj = new ZmReport();
            $keyN   = $modobj->attributeLabels();
            /** 日志*/
            self::$logobj['desc'] = 'id:'.intval($keyN['ArticleID']);
            
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
            	print_r($update);die;
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
        $modobj = new ZmReport();
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
	    $modobj = new ZmReport();
	    $users = new Users();
        foreach ($ids as $k => $v){
            $ids[$k] = intval($v);
        }
        /** 日志*/
        self::$logobj['desc'] = 'id:'.implode(',', $ids);
        
	    $transaction = Yii::$app->db->beginTransaction();
	    try{
	    	$userid = $modobj->findOne(['id'=>$ids]);
		    if(!$modobj->updateAll(['status' => intval(Yii::$app->request->post('status')),'readddate'=>date("Y-m-d",time()),'readdtime'=>date("Y-m-d H:i:s",time())],['id' => $ids])){
			    $transaction->rollback();//如果操作失败, 数据回滚
			    return ['s'=>0,'m'=>'更新状态失败'];
			
		    }
		    $arr = [];
		    $userinfo = $users->findOne(['loginname'=>$userid['userid']]);
		    if($userinfo['dllevel']>0){
			    $arr = ['bdl' => 1,'bd' => 0, 'dllevel' => 0 ,'sheng' => 0, 'shi' => 0 , "xian" => 0];
		    }else{
			    $arr = ['bdl' => 1];
		    }
		    if(!$users->updateAll($arr,['id' => $userinfo['id']])){
			    $transaction->rollback();//如果操作失败, 数据回滚
			    return ['s'=>0,'m'=>'用户报单级别修改失败'];
			
		    }
		    if($userinfo['dllevel']>0){
			    if(!$users->updateAll(['bdr' => $userinfo['loginname'],'baodan'=>""],['baodan' => $userinfo['loginname']])){
				    $transaction->rollback();//如果操作失败, 数据回滚
				    return ['s'=>0,'m'=>'更新数据失败'];
			    }
		    }
		    $transaction->commit();
		    return ['s'=>1,'m'=>'编辑成功'];
	    	
	    }catch (Exception $e) {
		    $transaction->rollback();//如果操作失败, 数据回滚
		    return ['s'=>0,'m'=>'编辑失败！'];
		
	    }
     
    }
}
