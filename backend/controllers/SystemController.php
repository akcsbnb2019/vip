<?php
namespace backend\controllers;

use Yii;
use backend\models\AdUser;

/**
 * 系统设置控制器
 */
class SystemController extends BaseController
{    
    /**
     * 列表
     * 
     * @return string
     */
    public function actionIndex()
    {
        pe('测');
        /*$modobj = new AdUser();
        $where = $modobj->find()->andWhere(['>','status',-1]);
        
        /* 模糊查询 
        if(Yii::$app->request->post('s')){
            $where->andWhere(['like', 'username', Yii::$app->request->post('s')]);
        }
        $data = $where->orderBy('sort ASC,id DESC')->all();
        
        return $this->render('index',[
            'model' => $data,
        ]);*/
    }
    
    /**
     * 商城对接
     * 
     * @return string
     */
    public function actionInterface($id = 0)
    {
        
        /* 执行更新操作 */
        if(Yii::$app->request->isAjax){
            /** 日志*/
            self::$logobj['desc'] = 'id:1,商城对接';
            if(Yii::$app->request->post('website')){
                
                $query = Yii::$app->db->createCommand("UPDATE jjsz SET website = '".Yii::$app->request->post('website')."' WHERE id=:id")->bindValue(':id', 1)->execute();
                if($query){
                    return ['s'=>1,'m'=>'提交成功','u'=>''];
                }
            }
            
            return ['s'=>0,'m'=>'提交失败'];
        }
        
        $query = Yii::$app->db->createCommand(" select * from jjsz where id=1 ")->queryOne();
        
        /* 初始化类型 */
        return $this->render('interface',[
            'website' => $query['website'],
        ]);
    }
}
