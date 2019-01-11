<?php
namespace backend\controllers;

use Yii;
use backend\models\Performancem;
use yii\data\Pagination;

/**
 * 业绩综合查询
 */
class PerformanceController extends BaseController
{
    /**
     * 列表
     * 
     * @return string
     */
    public function actionIndex($limit = 0, $count = 0)
    {
		if (Yii::$app->request->isPost) {
			$pfm = new Performancem();
			$where = $pfm->find()->groupBy('userid')->where(['>','id',0]);
			$pos = Yii::$app->request->post();

			$types = ['兑换','转入','管理员取消兑换','管理奖','销售奖'];
			if (isset($pos['types'])) {
				$where->andWhere(['in','types',$pos['types']]);
			} else {
				$where->andWhere(['not in','types',$types]);
			}

			if (!empty(trim($pos['s']))) {
				$where->andWhere('userid = :userid',[':userid' => trim($pos['s'])]);
				if (!empty(trim($pos['begtime']))) {$where->andWhere(['>=','adddate',$pos['begtime']]);}
				if (!empty(trim($pos['endtime']))) {$where->andWhere(['<=','adddate',$pos['endtime']]);}
			} else {
				if (empty($pos['begtime']) && empty($pos['endtime'])) {
					$where->andWhere(['>=','adddate',date("Y-m-d",strtotime("-7 day"))]);
				} elseif (!empty($pos['begtime']) && !empty($pos['endtime'])) {

					if (strtotime($pos['endtime']) - strtotime($pos['begtime']) <= 604800) {
						$where->andWhere(['>=','adddate',$pos['begtime']]);
						$where->andWhere(['<=','adddate',$pos['endtime']]);
					} else {
						$where->andWhere(['>=','adddate',date("Y-m-d",strtotime("-7 day"))]);
					}

				} else {
					if (!empty($pos['begtime']) && strtotime($pos['begtime']) > strtotime("-7 day")) {
						$where->andWhere(['>=','adddate',$pos['begtime']]);
					} else {
						$where->andWhere(['>=','adddate',date("Y-m-d",strtotime("-7 day"))]);
					}

					if (!empty($pos['endtime'])) {
						$where->andWhere(['<=','adddate',$pos['endtime']]);
					}
				}
			}

			

            $page  = new Pagination([
                'totalCount' => (AJAX && $count ? Yii::$app->request->post('count') : $where->count()),
            ]);
			$page->defaultPageSize = intval($limit)<10?10:(intval($limit)>30?30:intval($limit));

			$pfmdata = $where->orderBy('amount DESC')->offset($page->offset)->limit($page->limit)->select(['id','userid','SUM(amount) as amount'])->all();
		} else {
			$pfmdata = [];
			$page = (object)[
				'totalCount' => 0,
				'page' => 0,
				'defaultPageSize' => 10,
			];
		}

		if(AJAX){
			$this->layout = 'kong';
			return [
				'html' => $this->render('list',[
					'model' => $pfmdata,
				]),
                'page' => $page ,
			];
		}else{
		    $this->layout = 'layui2';
			return $this->render('index',[
				'model' => $pfmdata,
				'page'  => $page,
			]);
		}
    }

}
