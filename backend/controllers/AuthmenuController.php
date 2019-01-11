<?php
namespace backend\controllers;

use Yii;
use backend\models\VipMenu;

/**
 * 权限菜单控制器
 */
class AuthmenuController extends BaseController
{
    /**
     * 类型设置
     * @var unknown
     */
    public static $types = [
        '1' => '普通类型',
        '2' => '高级类型',
        '3' => 'Url连接',
    ];
    /**
     * 列表
     * 
     * @return string
     */
    public function actionIndex($cid = 0)
    {
        $menu = new VipMenu();
        
        return $this->render('index',[
            'model' => $menu,
            'cat'   => $this->getcat($cid),
            'types' => self::$types,
        ]);
    }
    /**
     * 列表
     * 
     * @return string
     */
    public function actionList($cid = 0)
    {
        $menu = new VipMenu();
        $where = $menu->find()->where([ 'cat_id' => intval($cid)])->andWhere(['>','status',-1]);
        $post = Yii::$app->request->post('VipMenu');
        if($post){
            /* 模糊查询 */
            if($post['name'] != '.'){
                $where->andWhere(['like', 'name', $post['name']]);
                $menu->name = $post['name'];
            }
        }
        $data = $where->orderBy('sort ASC,id DESC')->asArray()->all();
        foreach ($data as $key=>$val){
            if(isset(self::$types[$val['type']])){
                $data[$key]['type'] = self::$types[$val['type']];
            }
            $data[$key]['icon'] = '<i class="larry-icon '.$val['icon'].'"></i>';
            $data[$key]['add_time'] = date('Y.m.d H:i:s',$val['add_time']);
        }
        if(AJAX){
            return [
                'code' => '',
                'count' => $where->count(),
                'data' => $data,
                'msg' => '',
            ];
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
            $menu = new VipMenu();
            /** 日志*/
            self::$logobj['desc'] = 'id:';
            
            /* 验证提交信息是否完整 */
            if (!$menu->load(Yii::$app->request->post()) ) {
                return ['status'=>0,'msg'=>'提交信息缺失！'];
            }
            if(!$menu->save()){
                $err = $menu->getErrors();
                list($first_key, $first) = (reset($err) ? each($err) : each($err));
                return ['status'=>0,'msg'=>$first['0']];
            }
            self::$logobj['desc'] = 'id:'.Yii::$app->db->getLastInsertId();
            return ['status'=>1,'msg'=>'提交成功','url'=>$this->urlTo('/'.THISID.'/index?cid='.Yii::$app->request->post('VipMenu')['cat_id'])];
        }
    }
    
    /**
     * edit 编辑
     * 
     * @return string
     */
    public function actionEdit($put = false)
    {
        /* 执行更新操作 */
        if($put && Yii::$app->request->isAjax){
            $pMenu = Yii::$app->request->post('VipMenu');
            /* 执行添加 */
            if($pMenu['id'] == 0){
                return self::actionAdd();
            }
            
            $menu = new VipMenu();
            $menu->kong = false;
            /** 日志*/
            self::$logobj['desc'] = 'id:'.intval($pMenu['id']);
            
            /* 验证提交信息是否完整 */
            if (!$menu->load(Yii::$app->request->post()) ) {
                return ['status'=>2,'msg'=>'提交信息缺失！'];
            }
            /* 自定义过滤 */
            if(!$menu->validate()){
                $err = $menu->getErrors();
                list($first_key, $first) = (reset($err) ? each($err) : each($err));
                return ['status'=>2,'msg'=>$first['0']];
            }
            /* 定义非己重复 */
            if($menu->find()->where(['name'=>$pMenu['name']])->andWhere(['NOT', ['id' => $pMenu['id']]])->count()){
                return ['status'=>2,'msg'=>'名称的值"'.$pMenu['name'].'"已经被占用了。'];
            }
            
            /* 提交定义 */
            $update = $menu->findOne(intval($pMenu['id']));
            if($update){
                foreach ($update as $k => $v){
                    if(isset($pMenu[$k]) && $v != $pMenu[$k]){
                        $update->$k = $pMenu[$k];
                    }
                }
                if($update->save()){
                    return ['status'=>1,'msg'=>'提交成功','url'=>$this->urlTo('/'.THISID.'/index?cid='.$pMenu['cat_id'])];
                }
            }
            
            return ['status'=>2,'msg'=>'更新失败'];
        }
        $post = Yii::$app->request->post();
        if(!isset($post['id'])){
            return ['status'=>2,'msg'=>'提交信息缺失！'];
        }
        
        $menu = new VipMenu();
        $data = $menu->findOne(['id'=>intval($post['id'])]);
        
        if(!$data){
            return ['status'=>2,'msg'=>'记录不存在！'];
        }
        return [
            'cat' => $this->getcat($data['cat_id']),
            'data' => $data
        ];
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
            return ['status'=>0,'msg'=>'没有可操作项'];
        }
        $ids = explode(',', Yii::$app->request->post('ids'));
        foreach ($ids as $k => $v){
            $ids[$k] = intval($v);
        }
        /** 日志*/
        self::$logobj['desc'] = 'id:'.implode(',', $ids);
        $menu = new VipMenu();
        if($menu->updateAll(['status' => intval(Yii::$app->request->post('status'))],['id' => $ids])){
            return ['status'=>1,'msg'=>'编辑成功'];
        }
        return ['status'=>0,'msg'=>'编辑失败！'];
    }
    /**
     * 返回父级
     * @param unknown $cid
     */
    private function getcat($cid)
    {
        
        $model = [
            'cid' => intval($cid),
            'pid' => 0,
            'cname' => '顶级菜单',
        ];
        if($cid > 0){
            $menu = new VipMenu();
            $data = $menu->findOne(['id'=>$cid]);
            if($data){
                $model['cname'] = $data['name'];
                $model['pid'] = $data['cat_id'];
            }
        }
        
        return $model;
    }
}
