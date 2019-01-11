<?php
namespace frontend\controllers;

use Yii;
use yii\data\Pagination;
use frontend\models\Neirong;

/**
 * 公告信息控制器
 */
class NewsController extends BaseController
{

    /**
     * 默认页面
     * @param number $limit
     * @param number $count
     * @return number[]|string[]|string[]|\yii\data\Pagination[]|string
     */
    public function actionIndex($limit = 15, $count = 1000)
    {
        $news = new Neirong();
        //指定账号显示所有
        if(Yii::$app->session->get('loginname') == 'q764297954'){
            $obj = $news->find();
        }else{
            $obj = $news->find()
                ->where(['<=', 'BegindateTime', date("Y-m-d H:i:s",time())])->andWhere(['>','status',0])
                ->andWhere(['>=', 'EnddateTime', date("Y-m-d H:i:s",time())])->andWhere(['types' => 4]);
        }

        /* 获取总记录数 */
        if(Yii::$app->request->post('count')){
            return [ 'count' => $obj->count() ];
        }
        $page = new Pagination(['totalCount' => $count]);
        $page->defaultPageSize = $limit == 15?15:30;
        $model = $obj->offset($page->offset)->limit($page->limit)->asArray()->select(['ArticleID','types','title','UpdateTime'])->orderBy('articleid DESC')->all();
        $page->params = ['list'=>'all'];
        
        if(Yii::$app->request->isAjax){
            return [ 'html' => $this->render('lists',['model' => $model]), 'page' => $page ];
        }else{
            return $this->render('list',[ 'model' => $model, 'page' => $page]);
        }
    }

    /**
     * 详情
     * @param number $id
     * @return \yii\web\Response|\frontend\models\Neirong|string
     */
    public function actionInfo($id = 0)
    {
        if(!$id){
            return $this->goBack($this->urlTo('/news/list'));
        }
        
        if(Yii::$app->request->isAjax){
            return Neirong::findOne(['ArticleID' => intval($id)]);
        }else{
            return $this->render('info', [ 'model' => Neirong::findOne(['ArticleID' => intval($id)]) ]);
        }
    }
}
