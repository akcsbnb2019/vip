<?php
namespace backend\controllers;

use Yii;
use backend\models\AdUser;
use backend\models\VipGroup;
use frontend\models\ChangeMoney;
use common\models\User;
use yii\data\Pagination;

/**
 * 转账记录管理
 */
class TransferController extends BaseController
{
    /**
     * 列表
     * 
     * @return string
     */
    public function actionIndex($limit = 0, $count = 0)
    {
		$head['title'] = "转账记录列表";
        $modobj = new ChangeMoney();
        $where = $modobj->find()->where(['>','change_money.id',0]);
		$pos = Yii::$app->request->post();

		if (!empty($pos['begtime'])) {
			$where->andWhere(['>=','change_time',$pos['begtime']]);
		}
		if (!empty($pos['endtime'])) {
			$where->andWhere(['<=','change_time',$pos['endtime']]);
		}
        if(!empty($pos['s'])){
            $where->andWhere(['like', 'send_userid',trim($pos['s'])]);
        }
		if(!empty($pos['r'])){
            $where->andWhere(['like', 'to_userid',trim($pos['r'])]);
        }

		$page  = new Pagination([
			'totalCount' => (AJAX && $count ? Yii::$app->request->post('count') : $where->count()),
		]);
		$page->defaultPageSize = intval($limit)<10?10:(intval($limit)>30?30:intval($limit));

        $data = $where->orderBy('change_money.id DESC')->offset($page->offset)->limit($page->limit)->leftJoin('users','users.loginname = change_money.to_userid')->asArray()->select(['send_userid','users.truename','to_userid','money','why_change','change_time'])->all();

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
				'head' => $head,
				'page' => $page,
			]);
        }
    }

}
