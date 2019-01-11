<?php
namespace frontend\controllers;

use Yii;
use frontend\models\Messagem;
use yii\data\Pagination;
use Exception;

/**
 * 留言管理控制器
 */
class MessageController extends BaseController
{

    /**
     * 默认页面
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $data = Yii::$app->request;
        return $this->render('index');
    }

    /**
     * 留言列表
     *
     * @return mixed
     */
    public function actionList($limit=0,$count=0)
    {
        $message= new Messagem();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post('Messagem');
            if(preg_match("/^[，。“”0-9A-Za-z_\\x{4e00}-\\x{9fa5}.]+$/u", $post['title1'], $toname)){
                $title = implode(",",$toname);
            }else{
                $title ="";
            }
        }else{
            $title='';
        }
        $where = $message->find()->where('title like :title')->addParams([':title'=>"%$title%"])->andWhere(['and','senduid='.UID,'flag>-1','parent_id=0']);

//        pr($where->count());

        $page  = new Pagination([
			'totalCount' => (Yii::$app->request->isAjax && $count ? Yii::$app->request->post('count') : $where->count()),
		]);
		$page->defaultPageSize = intval($limit)<10?10:(intval($limit)>30?30:intval($limit));
		
        $model = $where->orderBy('id desc')->offset($page->offset)->limit($page->limit)->asArray()->all();
//        pr($model);

		if(Yii::$app->request->isAjax){
            return [
				'html' => $this->render('lists',[
                    'message' => $message,
                    'model' => $model,
				]),
                'page' => $page ,
			];
        }else{
            return $this->render('list',[
                'model' => $model,
                'message' => $message,
                'page' => $page,
            ]);
        }
    }

    /**
     * 留言详情
     *
     * @return mixed
     */
    public function actionMessageinfo($id = 0)
    {
        $userid = UID;

        $message = new Messagem();
		$where = $message->find()->where(['=','parent_id',$id]);

        $info = $message->find()->where(['id'=>$id,'senduid'=>$userid])->asArray()->one();
        $info['loginname'] = Yii::$app->session->get('loginname');
		$recdata = $where->orderBy('id asc')->asArray()->select(['recuid','content','addtime','senduid','id'])->all();

		if ($info['states'] == 2) {
			$message->updateAll(['states' => 3],['id' => $id]);
		}
        if(Yii::$app->request->isAjax){
            return [
                'info' => $info,
                'model'=>$message,
				'recdata' => $recdata,
            ];
        }else{
            return $this->render('info',[
                'info' => $info,
                'model'=>$message,
                'recdata' => $recdata,
            ]);
        }
    }

    /*
     * 详细内容处理
     * */
    public function actionInfoform1(){
        if(Yii::$app->request->isAjax) {
			$modobj = new Messagem();
			$modobj1 = new Messagem();
            $message = Yii::$app->request->post('Messagem');

            if (!$modobj->load(Yii::$app->request->post())) {
                return ['status'=>0,'msg'=>'提交信息缺失！'];
            }
			$modobj->senduid = UID;
            $modobj->title=$message['title'];
            $modobj->parent_id=$message['parent_id'];
			$modobj->flag = 0;
			$modobj->states = 0;
			$modobj->recuid = 0;
			$modobj->addtime = time();
            /* 自定义过滤 */
            if(!$modobj->validate()){
                $err = $modobj->getErrors();
                list($first_key, $first) = (reset($err) ? each($err) : each($err));
                return ['status'=>0,'msg'=>$first['0']];
            }
			$modobj1->updateAll(['states' => 3,'uptime'=>time()],['id' => $message['parent_id']]);
            if(!$modobj->save()){
                $err = $modobj->getErrors();
                list($first_key, $first) = (reset($err) ? each($err) : each($err));
                return ['status'=>0,'msg'=>$first['0']];
            }
            return ['status'=>6,'msg'=>'提交成功','url'=>$this->urlTo('/message/messageinfo?id='.$message['parent_id'])];
        }
    }

    /*
     * 详细内容处理
     * */
    public function actionInfooff(){
        $message = new Messagem();

        if(Yii::$app->request->isAjax) {
            $id = Yii::$app->request->get('id');

            $count = $message->find()->where("id=:id",[':id'=>$id])->andWhere(['flag'=>1])->count();
            if($count>0){
                return ['status'=>0,'msg'=>'问题已经关闭,请勿重复点击！'];
            }else{
                $transaction=Yii::$app->db->beginTransaction();
                try{
                    $message->updateAll(['flag'=>1],'id=:id',[':id'=>$id]);

                    $transaction->commit();//提交事务会真正的执行数据库操作
                    return ['status'=>6,'msg'=>'关闭成功!'];
                }catch (Exception $e) {
                    $transaction->rollback();//如果操作失败, 数据回滚
                    return ['status'=>0,'msg'=>'问题关闭失败,请刷新页面后重试'];
                }
            }

        }
    }

    /**
     * 发送留言
     *
     * @return mixed
     */
    public function actionSend()
    {
        $model = new Messagem();
        return $this->render('send',[
            'model'=>$model
        ]);
    }
    /*
     * 留言处理
     * */
    public function actionSendform(){
        if(Yii::$app->request->isAjax) {
			$modobj = new Messagem();

            if (!$modobj->load(Yii::$app->request->post())) {
                return ['status'=>0,'msg'=>'提交信息缺失！'];
            }
			$modobj->senduid = UID;
			$modobj->flag = 0;
			$modobj->recuid = 0;
			$modobj->states = 1;
			$modobj->parent_id = 0;
			$modobj->addtime = time();
			$modobj->uptime = time();
            /* 自定义过滤 */
            if(!$modobj->save()){
                $err = $modobj->getErrors();
                list($first_key, $first) = (reset($err) ? each($err) : each($err));
                return ['status'=>0,'msg'=>$first['0']];
            }
            return ['status'=>6,'msg'=>'提交成功','url'=>$this->urlTo('/message/list')];
        }
    }
}
