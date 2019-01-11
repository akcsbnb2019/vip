<?php
	
	namespace frontend\controllers;
	
	use backend\models\Users;
	use frontend\models\EUsers;
	use Yii;
	use frontend\models\Income;
	use frontend\models\ZmIncome;
	use frontend\models\Uso;
	use frontend\models\ZmReport;
	use frontend\models\UpUsersLevel;
	use frontend\models\OrderInfo;
	use frontend\models\OrderGoods;
	use frontend\models\Goods;
	use frontend\models\Region;
	use common\models\User;
	use common\models\Identity;
	use Exception;
	use frontend\region\RegionAction;
	use frontend\models\ZmPositionLog;
	use frontend\models\ZmPosition;
	use frontend\models\UserAddress;
	
	/**
	 * 用户信息控制器
	 */
	class SetinfoController extends BaseController
	{
		
		/**
		 * 注册查询记录
		 * @var unknown
		 */
		public static $reg = false;
		/**
		 * 会员中心
		 * @return string
		 */
		public function actionIndex()
		{
			if(UID!=1){
				return $this->msg('非法访问!',['icon'=>0,'url'=>'/index/main']);
			}
			echo "你知道命令吗?.";die;
		}
		
		/**
		 * 平移升级带订单
		 * @return number[]|string[]|number[]|unknown[]|number[]|string[]|unknown[]|string
		 */
		public function actionPupviporder()
		{
			if(UID!=1){
				return $this->msg('非法访问!',['icon'=>0,'url'=>'/index/main']);
			}
			$eu = new EUsers();
			$eu_ad = new UserAddress();
			/** 升级信息*/
			$vip_table = [
				1       =>      ['level'  =>  "1",'fd'  =>  "3000",],
				2       =>      ['level'  =>  "2",'fd'  =>  "30000",],
				3       =>      ['level'  =>  "3",'fd'  =>  "90000",],
			];
			$vip_show = [
				1       =>      1350,
				2       =>      1350,
				3       =>      1350,
			];
			/** 升级模型*/
			
			$income  = new ZmIncome();
			
			$level = 3;
			/** 需要扣除的金额*/
			$amount = 1350;
			if ($amount == 1350) {
				/*v0->v3*/
				$goods_id = 2551;
			}
			/** 升级对应金额需要下发的积分数量*/
			$points = ['1350' => 900];
			$zm = new ZmPosition();
			$row1  = Yii::$app->db->createCommand('select loginname from users as u right JOIN zm_position as zp ON u.id=zp.users_id where zp.pan=1 order by u.id asc')->queryAll();
			$count = count($row1);
			$row  = Yii::$app->db->createCommand('select loginname from users as u right JOIN zm_position as zp ON u.id=zp.users_id where zp.pan=1 order by u.id asc limit 1')->queryAll();
			
			foreach ($row as $key => $val) {
				$uinfo = Yii::$app->mycomponent->getusers($val['loginname']);
				$euinfo = $eu->findOne(['user_name' => $uinfo['loginname']]);
				$address_info = $eu_ad->findOne(['address_id' => $euinfo['address_id']]);
				if (empty($address_info)) {
					$reg = $row = Yii::$app->db->createCommand("update zm_position set pan=3 where users_id=" . $uinfo['id'])->execute();
					if ($reg === false) {
						Yii::$app->mycomponent->pr(['status' => 2, 'msg' => $reg]);
						echo 3;
						die();
					}
					continue;
				}
				$order_fee = array(
					'user_id' => $euinfo['user_id'],//金额
					'surplus' => 1350,//金额
					'goods_amount' => 1350,//商品金额
					'consignee' => $address_info['consignee'],//收货人姓名
					'province' => $address_info['province'],   //收货人省
					'city' => $address_info['city'],   //收货人市
					'district' => $address_info['district'],   //收货人县
					'address' => $address_info['address'],   //收货人具体地址
					'tel' => $address_info['tel'],   //收货人手机号
				);
				//$order_info_sql = "insert info ecs_order_info(`order_sn`,`order_status`,`shipping_status`,`pay_status`,`shipping_id`,`shipping_name`,`country`,`pay_id`,`pay_name`,`how_oos`,`shipping_fee`,`referer`,`add_time`,`confirm_time`,`pay_time`,`agency_id`,`inv_type`,`tax`,`discount`,`buyin_money`,`buyout_money`,`tihuo_desc`,`user_id`,`surplus`) values('".$this->get_order_sn()."',1,0,2,7,'快递',1,11,'余额或购物券支付','等待所有商品备齐后再发',0,'会员系统',".(time()-28800).",".(time()-28800).",".(time()-28800).",0,'',0,0,0,0,'',".$euinfo['user_id'].",1500,1500,'".$address_info['consignee']."','".$address_info['province']."','".$address_info['city']."','".$address_info['district']."','".$address_info['address']."','".$address_info['tel']."')";
				//$order_goods_sql = "insert into ecs_order_goods(`order_id`,`goods_id`,`goods_name`,`goods_sn`,`goods_number`,`market_price`,`goods_price`,`is_real`,`goods_attr`) values(?,2551,'1350升级包','sole002551',1,'1620','1350',1,'')";
				
				try {
					/** 插入升级记录*/
					$reg = Yii::$app->db->createCommand()->insert('up_reg_users', array(
						'loginname' => $uinfo['loginname'],
						'standardlevel' => $uinfo['standardlevel'],
						'types' => 4,
						'up_standardlevel' => 3,
						'addtime' => date('Y-m-d H:i:s', time()),
						'admin_name' => $uinfo['loginname']
					))->execute();
					if ($reg === false) {
						Yii::$app->mycomponent->pr(['status' => 2, 'msg' => $reg]);
						echo 0;die;
					}
					$addid = Yii::$app->db->getLastInsertID();
					$ret = Yii::$app->mycomponent->setkeys('standardlevel', $level, true);
					if ($ret === false) {
						Yii::$app->mycomponent->pr(['status' => 2, 'msg' => '2']);
						echo "2";
						die();
					}
					Yii::$app->mycomponent->uptime();
					/** 升级下发奖金*/
					$ret = Yii::$app->mycomponent->orderPoints($addid, $points[$amount], 3);
					if ($ret === false) {
						Yii::$app->mycomponent->pr(['status' => 2, 'msg' => '3']);
						echo "3";
						die();
					}
					$reg = Yii::$app->db->createCommand("update users set jihuotime='".date('Y-m-d H:i:s', time())."' where id=" . $uinfo['id'])->execute();
					if ($reg === false) {
						Yii::$app->mycomponent->pr(['status' => 22, 'msg' => $reg]);
						echo 3;
						die();
					}
					/** 生成订单*/
					$order_info = $this->addOrder($order_fee);
					
					$rets = Yii::$app->db->createCommand()->Insert('ecs_order_info', $order_info)->execute();
					if (empty($rets) || $rets === false) {
						Yii::$app->mycomponent->pr(['status' => 2, 'msg' => '5']);
						echo "5";
						die();
					}
					
					$order_id = Yii::$app->db->getLastInsertID();
					$goods_info = $this->addOrderGoods($order_id, $goods_id);
					$rets = Yii::$app->db->createCommand()->Insert('ecs_order_goods', $goods_info)->execute();
					if (empty($rets) || $rets === false) {
						Yii::$app->mycomponent->pr(['status' => 2, 'msg' => '6']);
						echo "6";
						die();
					}
					$reg = $row = Yii::$app->db->createCommand("update zm_position set pan=2 where users_id=" . $uinfo['id'])->execute();
					if ($reg === false) {
						Yii::$app->mycomponent->pr(['status' => 2, 'msg' => $reg]);
						echo 3;
						die();
					}
				} catch (Exception $e) {
					Yii::$app->mycomponent->pr(['status' => 2, 'msg' => '8']);
					echo $e;
					die;
				}
			}
			Yii::$app->mycomponent->commit();
			if($count>0){
				echo "<script>window.location.href='/setinfo/pupviporder'</script>";
				die;
			}else{
				echo 1111;
			}
		}
		/**
		 * 平移升级无订单
		 * @return number[]|string[]|number[]|unknown[]|number[]|string[]|unknown[]|string
		 */
		public function actionPupvip()
		{
			if(UID!=1){
				return $this->msg('非法访问!',['icon'=>0,'url'=>'/index/main']);
			}
			/** 验证级别*/
			$up_id = 3;
			
			/** 升级信息*/
			$vip_table = [
				1 => ['level' => "1", 'fd' => "3000",],
				2 => ['level' => "2", 'fd' => "30000",],
				3 => ['level' => "3", 'fd' => "90000",],
			];
			$vip_show = [
				1 => 1350,
				2 => 1350,
				3 => 1350,
			];
			/** 升级模型*/
			/** ajax 升级入库处理*/
			$level = 3;
			
			if (empty($level) || !isset($vip_show[$level])) {
				return ['status' => 2, 'msg' => '请勿非法修改数据，刷新页面后重试！'];
			}
			/** 需要扣除的金额*/
			$amount = $vip_show[$level];
			/** 查看余额*/
			if ($amount == 1350) {
				/*v0->v3*/
				$goods_id = 2551;
			}
			/** 升级对应金额需要下发的积分数量*/
			$points = ['1350' => 900];
			if (!isset($points[$amount])) {
				return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => '请勿非法修改数据，刷新页面后重试！']);
			}
			$row1  = Yii::$app->db->createCommand('select loginname from users as u right JOIN zm_position as zp ON u.id=zp.users_id where zp.pan=1 order by u.id asc')->queryAll();
			$count = count($row1);
			$row  = Yii::$app->db->createCommand('select loginname from users as u right JOIN zm_position as zp ON u.id=zp.users_id where zp.pan=1 order by u.id asc limit 1')->queryAll();
			foreach ($row as $key=>$val) {
				$uinfo = Yii::$app->mycomponent->getusers($val['loginname']);
				if (!isset($vip_show[$level])) {
					echo -1;
					die;
				}
				try {
					if (!empty($uinfo['loginname'])) {
						$reg = Yii::$app->db->createCommand()->insert('up_reg_users', array(
							'loginname' => $uinfo['loginname'],
							'standardlevel' => $uinfo['standardlevel'],
							'types' => 4,
							'up_standardlevel' => 3,
							'addtime' => date('Y-m-d H:i:s', time()),
							'admin_name' => $uinfo['loginname']
						))->execute();
						if ($reg === false) {
							Yii::$app->mycomponent->pr(['status' => 2, 'msg' => $reg]);
							echo 0;die;
						}
					}
					$addid = Yii::$app->db->getLastInsertID();
					$ret = Yii::$app->mycomponent->setkeys('standardlevel', $level, true);
					if ($ret === false) {
						Yii::$app->mycomponent->pr(['status' => 2, 'msg' => $reg]);
						echo 1;die;
					}
					Yii::$app->mycomponent->uptime();
					/** 升级下发奖金*/
					$ret = Yii::$app->mycomponent->orderPoints($addid, $points[$amount], 3);
					if ($ret === false) {
						Yii::$app->mycomponent->pr(['status' => 2, 'msg' => $reg]);
						echo 2;die;
					}
					$reg = Yii::$app->db->createCommand("update users set jihuotime='".date('Y-m-d H:i:s', time())."' where id=" . $uinfo['id'])->execute();
					if ($reg === false) {
						Yii::$app->mycomponent->pr(['status' => 22, 'msg' => $reg]);
						echo 3;
						die();
					}
					$reg = Yii::$app->db->createCommand("update zm_position set pan=2 where users_id=" . $uinfo['id'])->execute();
					if ($reg === false) {
						Yii::$app->mycomponent->pr(['status' => 2, 'msg' => $reg]);
						echo 3;die;
					}
				} catch (Exception $e) {
					Yii::$app->mycomponent->pr(['status' => 2, 'msg' => $e]);
					echo $e;die;
				}
			}
			Yii::$app->mycomponent->commit();
			if($count>0){
				echo "<script>window.location.href='/setinfo/pupvip'</script>";
				die;
			}else{
				echo 1111;
			};
		}
		public function addOrder($row){
			/*
				 * 初始化订单数据
				 * */
			$order_sn = $this->get_order_sn();
			$order = array(
				'order_sn'     =>   $order_sn,    //订单状态
				'order_status'     => 1,    //订单状态
				'shipping_status'  => 0,    //收货状态
				'pay_status'        =>  2,  //支付状态
				'shipping_id'           =>  7,  //发货状态
				'shipping_name'           =>  '快递', //发货状态名称
				'country'               =>    1,   //收货人国
				'pay_id'           =>  11,  //支付方式
				'pay_name'           =>  '余额或购物券支付',    //支付方式说明
				'how_oos'           =>  '等待所有商品备齐后再发',  //发货详情
				'shipping_fee'           =>  0,  //运费
				'referer'           =>  '会员系统',  //标识订单来源
				'add_time'           =>  time()-28800,  //订单添加时间
				'confirm_time'           =>  time()-28800,  //订单确认时间
				'pay_time'           =>  time()-28800,  //订单支付时间
				'agency_id'           => 0,
				'inv_type'           => '',
				'tax'               =>  0,
				'discount'           => 0,
				'buyin_money'           => 0,
				'buyout_money'           => 0,
				'tihuo_desc'           => '',
			);
			$order = array_merge($order,$row);
			return $order;
		}
		/*
		 * 插入订单商品数据
		 * */
		public function addOrderGoods($order_id,$goods_id){
			/*
				 * 初始化订单数据
				 * */
			$goods = new Goods();
			$goods_row = $goods->findOne(['goods_id'=>$goods_id]);
			$asgoods = array(
				'order_id'     => $order_id,    //订单状态
				'goods_id'  => $goods_id,    //收货状态
				'goods_name'        =>  $goods_row['goods_name'],  //支付状态
				'goods_sn'           =>  $goods_row['goods_sn'],  //发货状态
				'goods_number'           =>  1, //发货状态名称
				'market_price'           =>  $goods_row['market_price'],  //支付方式
				'goods_price'           => $goods_row['shop_price'],    //支付方式说明
				'is_real'           =>  1,  //发货详情
				'goods_attr'           =>  '',
			);
			return $asgoods;
		}
		
		/**
		 * 得到新订单号
		 *
		 * @return string
		 */
		function get_order_sn() {
			/* 选择一个随机的方案 */
			$order= new OrderInfo();
			mt_srand((double) microtime() * 1000000);
			$sn = date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
			
			/* 检查订单号是否重复 */
			$is_existed = $order->findOne(['order_sn'=>$sn]);
			if ($is_existed['order_id'] > 0) {
				$sn = $this->get_order_sn();
			}
			return $sn;
		}
	}
