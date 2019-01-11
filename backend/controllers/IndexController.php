<?php
namespace backend\controllers;

use Yii;

/**
 * Site controller ss
 */
class IndexController extends BaseController
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        /* 获取菜单 */
        $trues = $this->urlNav();

        if(Yii::$app->request->isAjax){
            if($trues){
                return ['status'=>3,'msg'=>'无权访问'];
            }
            return ['status'=>1,'msg'=>'已刷新'];
        }
        
        if($trues){
            return false;
        }
        $this->layout = 'index';
        
        return $this->render('index');
    }
    
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionDefault($name = 'index',$type = 0)
    {
        
    }

    public function actionMenudatas()
    {
        $nav = Yii::$app->redis->get('bac-nav'.GROUPID);
        if($nav){
            return json_decode($nav);
        }
        return false;
    }

    /**
     * 清空缓存数据
     */
    public function actionFlush()
    {
        //Yii::$app->redis->executeCommand('FLUSHDB');
        Yii::$app->redis->setex('bac-auth'.GROUPID,3,false);
        Yii::$app->redis->setex('bac-nav'.GROUPID,3,false);
        Yii::$app->redis->setex('bac-hav'.GROUPID,3,false);
        $this->urlNav();
        return ['status'=>1,'msg'=>'缓存清除成功！'];
    }
    
    /* 权限菜单验证 */
    private function urlNav($refr = true)
    {
        /* 获取权限列表 */
        if(empty(self::$group->auth)){
            return $this->goBack($this->urlTo('/site/main'));
        }
        /* 检测缓存 */
        $nav = Yii::$app->redis->get('bac-nav'.GROUPID);
        if($nav && $refr){
            self::$group->nav = json_decode($nav);
            return false;
        }
    
        $menu = new \backend\models\VipMenu();
        $data = $menu->find()->asArray()->where(['>','status',0])->andWhere(['type'=>[1,2]])->orderBy('sort ASC,id DESC')->select('id,cat_id as pid,name as title,icon as font,icon,url_key as url,type as t,subset as z')->all();
        $menu = $auth = [];
        foreach ($data as $v){
            $v['font'] = 'larry-icon';
            $v['icon'] = 'larry-'.$v['icon'];
            $v['spread'] = '';
            $menu[$v['id']] = $v;
        }
        /* 权限排序&默认包含 */
        $all = ['0'];
        foreach ($menu as $v){
            if(isset($menu[$v['pid']]) && (!isset($auth[$menu[$v['pid']]['url']][$v['url']]) || $menu[$v['pid']]['z'] == 0)){
                $auth[$menu[$v['pid']]['url']][$v['url']] = $v;
            }
        }
        /* 权限列表 */
        foreach (self::$group->auth as $k => $v){
            if(isset($auth[$k])){
                $all[$v->id] = $i = $v->id;
                $d = $menu[$i]['pid'];
                if($d != 0){
                    $all[$d] = $d;
                    if(isset($menu[$d]) && $menu[$d]['pid'] != 0){
                        $all[$menu[$d]['pid']] = $menu[$d]['pid'];
                    }
                }
                foreach ($v as $k2 => $v2){
                    if(isset($auth[$k][$k2])){
                        $all[$auth[$k][$k2]['id']] = $auth[$k][$k2]['id'];
                    }
                }
            }
        }
        /* 权限菜单 */
        foreach ($menu as $v){
            $na = 'i'.$v['pid'];
            $nb = 'i'.$v['id'];
            if(in_array($v['pid'], $all) && in_array($v['id'], $all) || $v['t'] == 3){
                if(!isset(self::$group->tree->$na)){
                    self::$group->tree->$na = (object)[];
                }
                $v['url'] = '/'.str_replace('_', '/', $v['url']);
                unset($v['t']);
                self::$group->tree->$na->$nb = (object)$v;
            }
        }
        
        /* 格式化缓存 */
        $nav = (object)[ 'code' => 0, 'msg'  => 'success', 'data' => []];
        
        $dTree = self::diTree(0);
        foreach ($dTree as $val){
            $nav->data[] = $val;
        }
        
        Yii::$app->redis->setex('bac-nav'.GROUPID,3600,json_encode($nav));
        self::$group = null;
        return false;
    }
    
    /**
     * 递归 完整树形菜单
     * @param unknown $pid
     * @return boolean|boolean[]|boolean[][]
     */
    private function diTree($pid)
    {
        $na = 'i'.$pid;
        if(!isset(self::$group->tree->$na)){
            return false;
        }
        $data = [];
        foreach (self::$group->tree->$na as $val){
            if($val->z == 0){
                $val->children = self::diTree($val->id);
            }
            if($pid == 0){
                $data['i'.$val->id] = $val;
            }else{
                $data[] = $val;
            }
        }
        return $data;
    }
}
