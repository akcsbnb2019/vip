<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * 后台核心继承控制器
 */
class DataController extends Controller
{
    public function behaviors()
    {
        return ['verbs' => ['class' => VerbFilter::className(),'actions' => ['logout' => ['post']]]];
    }
    public function actions()
    {
        return ['error' => ['class' => 'yii\web\ErrorAction']];
    }
    
    public function actionIndex()
    {
        $ones = Yii::$app->db;
        $sTr  = [];
        /**
         * 变更会员管理系统管理员表结构
         * @var string $tableName
         
        $tableName = 'adhgfqws65ljdlgr';
        $inTab = $ones->createCommand("SHOW TABLES LIKE '".$tableName."'")->queryOne();
        if($inTab==null){
            echo '<br>U管理员原表不存在，无法操作变更';
        }else{
            $Cval = $ones->createCommand("SELECT * FROM ".$tableName)->queryOne();
            $newTab = 'zm_user_admin';
            $upUAdmin = 'AlTER TABLE `'.$tableName.'` RENAME TO `'.$newTab.'` ';
            $upUAKey  = [
                'realname'      => 'ALTER TABLE `'.$tableName.'` CHANGE `realname` `realname` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL',
                'password'      => 'ALTER TABLE `'.$tableName.'` CHANGE `password` `password` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL',
                'LastLoginIP'   => 'ALTER TABLE `'.$tableName.'` CHANGE `LastLoginIP` `LastLoginIP` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL',
                'LastLoginTime' => 'ALTER TABLE `'.$tableName.'` CHANGE `LastLoginTime` `LastLoginTime` date NOT NULL',
                'permission'    => 'ALTER TABLE `'.$tableName.'` CHANGE `permission` `permission` bigint(64) UNSIGNED NOT NULL DEFAULT 0',
            ];
            if(!isset($Cval['groupid'])){
                $upUAKey['groupid'] = 'ALTER TABLE `'.$tableName.'` ADD `groupid` mediumint(5) UNSIGNED NOT NULL DEFAULT 0';
            }
            if(!isset($Cval['status'])){
                $upUAKey['status'] = 'ALTER TABLE `'.$tableName.'` ADD `status` tinyint(3) NOT NULL DEFAULT 0';
            }
            if(!isset($Cval['sort'])){
                $upUAKey['sort'] = 'ALTER TABLE `'.$tableName.'` ADD `sort` tinyint(3) UNSIGNED NOT NULL DEFAULT 0';
            }
            
            $outerTr = $ones->beginTransaction();
            try{
                
                foreach ($upUAKey as $key => $val){
                    $rT = $ones->createCommand($val)->execute();
                    $sTr[] = '<br>U管理员原表,字段'.$key.'变更如下<br>'.$val;
                }
                $rT = $ones->createCommand($upUAdmin)->execute();
                $sTr[] = '<br>U管理员原表变更为'.$newTab.'<br>('.$upUAdmin.');';
                
                $outerTr->commit();
            } catch (\Exception $e){
                $outerTr->rollBack();
                throw $e;
            }
        }*/

		$tableName = 'vip_group2';
        $inTab = $ones->createCommand("SHOW TABLES like '".$tableName."'")->queryOne();
        if($inTab==null){

 			/* $sql = "CREATE TABLE ".$tableName." (
				`id` mediumint(5) unsigned NOT NULL AUTO_INCREMENT,
				`name` varchar(50) NOT NULL,
				`desc` varchar(255) NOT NULL,
				`auth` text NOT NULL,
				`sort` tinyint(3) unsigned NOT NULL DEFAULT '0',
				`status` tinyint(1) NOT NULL DEFAULT '0',
				`add_time` int(10) unsigned NOT NULL DEFAULT '0',
				`type` tinyint(1) unsigned NOT NULL DEFAULT '0',
				PRIMARY KEY (`id`),
				KEY `name` (`name`) USING BTREE
			)";

			$Cval = $ones->createCommand($sql)->execute(); */

        }else{
			echo $tableName.' 表已存在<br>';
		}
        
        pe($sTr);

    }

	protected $dbdata_path = "dbdata";
	
	/**
    * 导出数据库
    */
	public function actionBakdata(){
		//$ones = Yii::$app->db;
		//$tables = $ones->getSchema()->getTableNames();
		$tables = array('appconfig');
        /** 日志*/
        self::$logobj['desc'] = 'Bakdata:导出数据库';
		
		foreach ($tables as $val) {
			$path = $this->getBackUpPath();

			$fileName = $this->makeFileName();
			
			$content = "SET FOREIGN_KEY_CHECKS=0; \r\n";

			//foreach ($tables as $key => $val) {
				$content .= "DROP TABLE IF EXISTS ". $this->addStyle($val) .";\r\n";
				$content .= $this->getTableStructure($val);  // 获取表结构
				$content .= ";\r\n";
				$content .= $this->getTableDatas($val);// 获取表数据
				$content .= "\r\n";
			//}

			$back_path = $this->getBackUpPath();
			$file_name = $this->makeFileName();
			$file = $back_path . '\\' . date("Ymd_His").'_'.$val.'_'.$file_name;
			$fp = fopen($file, 'w');
			@fwrite($fp, $content);
			fclose($fp);
		}

    }
	
	/** 
    * 删除备份
    */  
	public function actionDeldata(){
		$files = $this->getSqlFiles();
        /** 日志*/
        self::$logobj['desc'] = 'Deldat:删除备份';
		
		foreach ($files as $v) {
			$this->deleteSqlFile($v['name']);
		}
	}

	/**
    * 还原数据库
    */
	public function actionRedata(){
		$files = $this->getSqlFiles();
        /** 日志*/
        self::$logobj['desc'] = 'Redata:还原数据库';
		
		foreach ($files as $v) {
			$this->recoverSqlFile($v['name']);
		}
	}

	/*
    * 备份地址
    */
    protected function getBackUpPath(){
        $path = dirname(dirname(__FILE__)) . '\\' . $this->dbdata_path;
        if(!file_exists($path)){
            @mkdir($path, 0777);
        }
        return $path;
    }
	
	/*
    *   文件名称
    */
    protected function makeFileName(){
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $name = '';
        for($i = 0; $i<5; $i++){
            $name .= $chars[mt_rand(0, strlen($chars)-1)];
        }
        return $name.'.sql';
    }
	
	/*
    * 给字段、表名 加上`
    */
    protected function addStyle($str){
         return "`{$str}`";
    }

	/*
    *   获取表结构
    */
    protected function getTableStructure($table){
        $data = Yii::$app->db->createCommand('SHOW CREATE TABLE ' . $table)->queryAll();
        return $data[0]['Create Table'];
    }
	
	/*
    *   获取表数据
    */
    protected function getTableDatas($table){
        $data = Yii::$app->db->createCommand('SELECT * FROM ' . $table)->queryAll();
        $fields = '';
        $values = '';
        $content = '';
        foreach ($data as $key => $val) {
            $fields = array_keys($val);
            $values = array_values($val);
            $sql = "INSERT INTO " . $this->addStyle($table) ." (";
            $sql .= "`" . implode("`, `", $fields) . "`) VALUES (";
            $sql .= "'" . implode("', '", $values) . "'); \r\n";
            $content .= $sql;
        }

        return $content;
    }

	/*
    * 获取所有的sql文件
    */
    public function getSqlFiles(){
        $path = dirname(dirname(__FILE__)) . '/' . $this->dbdata_path;
        $sqls = [];
        if(file_exists($path)){
            $dir_handle = @opendir($path);
            while($file = @readdir($dir_handle)){
                $file_info = pathinfo($file);
                if($file_info['extension'] == 'sql'){
                    $sql['name'] = $file;
                    $sql['create_time'] = date('Y-m-d H:i:s', filectime($path . '/' . $file));
                    $sqls[] = $sql;
                }
            }
        }
        return $sqls;
    }

    /**
    *   还原数据库
    */
    public function recoverSqlFile($sqlFileName){
        $path = dirname(dirname(__FILE__)) . '/' . $this->dbdata_path;
        $sqlFile = $path . '/' . $sqlFileName;
        if(file_exists($sqlFile)){
            $sqls = file_get_contents($sqlFile);
            Yii::$app->db->createCommand($sqls)->execute();
        } else {
			echo "没有备份数据";
		}
    }

    /*
    * 删除数据备份
    */
    public function deleteSqlFile($sqlFileName){
        $path = dirname(dirname(__FILE__)) . '/' . $this->dbdata_path;
        $sqlFile = $path . '/' . $sqlFileName;
        if(file_exists($sqlFile)){
            @unlink($sqlFile);
        }
    }

}
