<?php
namespace backend\controllers;

use Yii;
use backend\models\Messagem;
use yii\data\Pagination;

/**
 * 站内信管理
 */
class InfoController extends BaseController
{
    /**
     * 列表
     * 
     * @return string
     */
    public function actionIndex($limit=0,$count=0)
    {
        $message= new Messagem();
		$where = $message->find()->where(['and','senduid>0','flag>-1','parent_id=0']);

		$page  = new Pagination([
			'totalCount' => (AJAX && $count ? Yii::$app->request->post('count') : $where->count()),
		]);
		$page->defaultPageSize = intval($limit)<30?30:(intval($limit)>50?50:intval($limit));

		$data = $where->orderBy('zm_chat.uptime DESC')->offset($page->offset)->limit($page->limit)->leftJoin('users','users.id = zm_chat.senduid')->asArray()->select(['zm_chat.id','zm_chat.senduid','users.loginname','zm_chat.title','zm_chat.addtime','zm_chat.states','zm_chat.flag'])->all();

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
                'page' => $page,
            ]);
        }

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
            $modobj = new Messagem();
            /** 日志*/
            self::$logobj['desc'] = 'id:'.intval(Yii::$app->request->post('id'));
            /* 验证提交信息是否完整 */
            if (!$modobj->load(Yii::$app->request->post(),'')) {
                return ['s'=>0,'m'=>'提交信息缺失！'];
            }

			$modobj->senduid = 0;
			$modobj->title = '0';
			$modobj->flag = 0;
			$modobj->states = 0;
			$modobj->recuid = Yii::$app->request->post('senduid');
			$modobj->addtime = time();
            /* 自定义过滤 */
            if(!$modobj->validate()){
                $err = $modobj->getErrors();
                list($first_key, $first) = (reset($err) ? each($err) : each($err));
                return ['s'=>0,'m'=>$first['0']];
            }

            if(!$modobj->save()){
                $err = $modobj->getErrors();
                list($first_key, $first) = (reset($err) ? each($err) : each($err));
                return ['s'=>0,'m'=>$first['0']];
            }
			$modobj->updateAll(['states' => 2],['id' => intval(Yii::$app->request->post('id'))]);
            return ['s'=>1,'m'=>'提交成功','u'=>$this->urlTo('/'.THISID.'/index')];
        }

        if(!$id){
            return $this->goBack($this->urlTo('/'.THISID.'/index'));
        }

        /* 取值 */
        $modobj = new Messagem();
        $data = $modobj->findOne(['id'=>intval($id)]);
		if(!$data){
            return $this->goBack($this->urlTo('/'.THISID.'/index'));
        }
		if ($data['states'] == 1 || $data['states'] == 3) {
			$modobj->updateAll(['states' => 4],['id' => $id]);
		}

		$recdata = $modobj->find()->where(['parent_id'=>$id,'flag'=>0])->orderBy('id ASC')->asArray()->select(['id','senduid','recuid','content','addtime'])->all();
        
        /* 初始化类型 */
        $this->layout = 'layui2';
        return $this->render('edit',[
            'data' => $data,
            'recdata' => $recdata,
        ]);
    }
	public function actionDel()
    {
		$ids = Yii::$app->request->post('ids');
		/* 验证信息 */
        if(!Yii::$app->request->post('ids')){
            return ['s'=>0,'m'=>'没有可操作项'];
        }
		$modobj = new Messagem();
		/** 日志*/
		self::$logobj['desc'] = 'id:'.intval($ids);
        if($modobj->deleteAll('id = :id',[':id' => $ids])){
            return ['s'=>1,'m'=>'删除成功'];
        }
		return ['s'=>0,'m'=>'删除失败！'];
	}
    /**
     * up status 状态编辑&删除
     * 
     * @return string
     */
    public function actionUpstatus()
    {
		$ids = Yii::$app->request->post('ids');
		$s = Yii::$app->request->post('status');
        /* 验证信息 */
        if(!$ids){
            return ['s'=>0,'m'=>'没有可操作项'];
        }
        $ids = explode(',', $ids);
        foreach ($ids as $k => $v){
            $ids[$k] = intval($v);
        }
        $modobj = new Messagem();
        /** 日志*/
        self::$logobj['desc'] = 'id:'.implode(',', $ids);
		$count = $modobj->find()->where(['id'=>$ids,'flag'=>-1])->count();
		if($count>0){
			return ['s'=>1,'m'=>'问题已关闭'];
		} else {
			if($modobj->updateAll(['flag' => $s],['id' => $ids])){
				return ['s'=>1,'m'=>'编辑成功'];
			}
			return ['s'=>0,'m'=>'编辑失败！'];
		}
    }
}
