<?php
namespace backend\controllers;

use Yii;
use backend\models\VipGroup;

/**
 * 管理员权限组控制器
 */
class AuthgroupController extends BaseController
{
    /**
     * 列表
     * 
     * @return string
     */
    public function actionIndex()
    {
        $modobj = new VipGroup();
        $where = $modobj->find()->andWhere(['>','status',-1]);
        
        /* 模糊查询 */
        if(Yii::$app->request->post('s')){
            $where->andWhere(['like', 'name', Yii::$app->request->post('s')]);
        }
        $data = $where->orderBy('sort ASC,id DESC')->all();
        
        $this->layout = 'pc';
        return $this->render('index',[
            'model' => $data,
        ]);
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
            $modobj = new VipGroup();
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
            self::$logobj['desc'] = 'id:'.Yii::$app->db->getLastInsertId();
            return ['s'=>1,'m'=>'提交成功','u'=>$this->urlTo('/'.THISID.'/index')];
        }
        
        /* 初始化类型 */
        $this->layout = 'pc';
        return $this->render('add');
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
            
            $modobj = new VipGroup();
            $pAuth = Yii::$app->request->post('VipGroup');
            /** 日志*/
            self::$logobj['desc'] = 'id:'.intval($pAuth['id']);
            
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
            $update = $modobj->findOne(intval($pAuth['id']));
            if($update){
                foreach ($update as $k => $v){
                    if(isset($pAuth[$k]) && $v != $pAuth[$k]){
                        $update->$k = $pAuth[$k];
                    }
                }
                if($update->save()){
                    $this->delGroup($id);
                    return ['s'=>1,'m'=>'提交成功','u'=>$this->urlTo('/'.THISID.'/index')];
                }
            }
            
            return ['s'=>0,'m'=>'更新失败'];
        }
        
        if(!$id){
            return $this->goBack($this->urlTo('/'.THISID.'/index'));
        }
        
        $modobj = new VipGroup();
        $data = $modobj->findOne(['id'=>intval($id)]);
        
        if(!$data){
            return $this->goBack($this->urlTo('/'.THISID.'/index'));
        }
        
        /* 初始化类型 */
        $this->layout = 'pc';
        return $this->render('edit',[
            'data' => $data
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
            $this->delGroup($v);
        }
        /** 日志*/
        self::$logobj['desc'] = 'id:'.implode(',', $ids);
        $modobj = new VipGroup();
        if($modobj->updateAll(['status' => intval(Yii::$app->request->post('status'))],['id' => $ids])){
            return ['s'=>1,'m'=>'编辑成功'];
        }
        return ['s'=>0,'m'=>'编辑失败！'];
    }
    
    /**
     * Up group 编辑权限属性
     *
     * @return string
     */
    public function actionUpgroup($id = 0)
    {
        /** 日志*/
        self::$logobj['desc'] = 'id:'.intval($id);
        /* 权限更新操作 */
        if(Yii::$app->request->isAjax){
            if(!Yii::$app->request->post('group')){
                return ['s'=>0,'m'=>'没有可操作项'];
            }
            $data = [];
            /* 格式权限项 */
            foreach (Yii::$app->request->post('group') as $key => $val){
                $key = explode('_', $key);
                if(isset($key[1])){
                    $data[$key[0]] = [
                        'id' => $key[1],
                    ];
                    foreach ($val as $k2 => $v2){
                        $k2 = explode('_', $k2);
                        if(isset($k2[1])){
                            $data[$key[0]][$k2[0]] = $k2[1];
                        }
                    }
                }
            }
            $modobj = new VipGroup();
            if($modobj->updateAll(['auth' => json_encode($data)],['id' => intval($id)])){
                $this->delGroup($id);
                return ['s'=>1,'m'=>'编辑成功','u'=>$this->urlTo('/'.THISID.'/index')];
            }
            return ['s'=>0,'m'=>'编辑失败！'];
        }
        
        $modobj = new VipGroup();
        $data = $modobj->findOne(['id'=>intval($id)]);
        if(!$data){
            return $this->goBack($this->urlTo('/'.THISID.'/index'));
        }
        
        $this->getMenu();
        /* 初始化类型 */
        $this->layout = 'pc';
        return $this->render('group',[
            'data' => $data,
            'group' => json_decode($data['auth']),
            'tree' => self::$group->tree,
        ]);        
    }
    
    /**
     * 返回菜单 结构
     * @param unknown $cid
     */
    private function getMenu()
    {
    
        $menu = new \backend\models\VipMenu();
        $data = $menu->find()->where(['>','status',0])->orderBy('sort ASC,id DESC')->all();
        
        /* 定义工作对象 */
        self::$group = (object)[
            'menu'=>(object)[],
            'tree'=>(object)[],
        ];
        foreach ($data as $val){
            if($val['type'] == 3){
                continue;
            }
            $na = 'i'.$val['cat_id'];
            $nb = 'i'.$val['id'];
            self::$group->menu->$nb = (object)[
                'id'   => $val['id'],
                'title' => $val['name'],
                'href'  => $val['url_key'],
                'pid'  => $val['cat_id'],
                'icon' => 'larry-'.$val['icon'],
                'zi'   => $val['subset'],
            ];
            if(!isset(self::$group->tree->$na)){
                self::$group->tree->$na = (object)[];
            }
            self::$group->tree->$na->$nb = self::$group->menu->$nb;
        }
    }
    
    /**
     * 清空缓存
     * @param unknown $id
     */
    private function delGroup($id)
    {
        Yii::$app->redis->set('bac-auth'.$id,false);
        Yii::$app->redis->set('bac-nav'.$id,false);
    }
}
