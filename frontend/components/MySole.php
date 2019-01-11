<?php
	namespace frontend\components;
	
	
	use Yii;
	use yii\base\Component;
	use yii\base\InvalidConfigException;
	use common\models\User;
	use frontend\models\ZmPosition;
	use frontend\models\ZmWeek;
	
	class MySole extends Component
	{
		/**
		 * 新的复消开关
		 * @var unknown
		 */
		public static $newfx   = 0.05;
		/**
		 * 新的推荐限制级别
		 * @var unknown
		 */
		public static $newtjl   = 0;
		/**
		 * 事务状态
		 * @var string
		 */
		protected static $start   = false;
		/**
		 * 入库方式,是否多条并写
		 * @var string
		 */
		protected static $sets   = true;
		/**
		 * 对拼/推荐/管理入库前队列数组
		 * @var unknown
		 */
		protected static $log     = null;
		/**
		 * 奖金入库前队列数组表(预发库)
		 * @var unknown
		 */
		protected static $tdg     = null;
		/**
		 * 旅游奖入库前队列数组表(预发库)
		 * @var unknown
		 */
		protected static $ly     = null;
		/**
		 * 爱心基金入库前队列数组表(预发库)
		 * @var unknown
		 */
		protected static $love     = null;
		/**
		 * 复消券入库前队列数组表(预发库)
		 * @var unknown
		 */
		protected static $fuxiao   = null;
		/**
		 * 计入
		 * @var unknown
		 */
		protected static $user_row = null;
		/**
		 * vip用户所有级别
		 * @var unknown
		 */
		protected static $levels   = array (
			1 => array ( 'id' => '1', 'name' => 'vip1', 'integral' => 300,  'limitintegral' => 3000  ),
			2 => array ( 'id' => '2', 'name' => 'vip2', 'integral' => 3000, 'limitintegral' => 30000 ),
			3 => array ( 'id' => '3', 'name' => 'vip3', 'integral' => 9000, 'limitintegral' => 90000 )
		);
		/**
		 * 销售奖
		 * @var array
		 */
		protected static $xs      = array('1' => 0.09, '2' => 0.12, '3' => 0.15);
		/**
		 * 管理奖
		 * @var unknown
		 */
		protected static $gl      = array('1' => 0.1, '2' => 0.1, '3' => 0.1, '4' => 0.05, '5' => 0.05);
		/**
		 * 直推奖
		 * @var unknown
		 */
		protected static $zt      = array('1' => 0.05, '2' => 0.05, '3' => 0.1);
		/**
		 * 是否重消的标识
		 * @var unknown
		 */
		protected static $cxtype  = 1;
		/**
		 * 级别设定
		 * @var unknown
		 * bonus 级别奖励百分比
		 * upgrade 升级会员基数
		 */
		protected static $level   = [
			'13' => ['name' => '见习主任', 'bonus' => 0, 'upnum' => 0, 'upgrade' => 12],
			'12' => ['name' => '主任', 'bonus' => 2, 'upnum' => 2, 'upgrade' => 11],
			'11' => ['name' => '经理', 'bonus' => 4, 'upnum' => 2, 'upgrade' => 10],
			'10' => ['name' => '高级经理', 'bonus' => 6, 'upnum' => 2, 'upgrade' => 9],
			'9'  => ['name' => '营销总监', 'bonus' => 8, 'upnum' => 2, 'upgrade' => 8],
			'8'  => ['name' => '高级总监', 'bonus' => 10, 'upnum' => 3, 'upgrade' => 7],
			'7'  => ['name' => '董事', 'bonus' => 11, 'upnum' => 3, 'upgrade' => 6],
			'6'  => ['name' => '总裁董事', 'bonus' => 12, 'upnum' => 3, 'upgrade' => 0],
		];
		/**
		 * 档期
		 */
		protected static $curwk  = null;
		/**
		 * 事务句柄
		 * @var unknown
		 */
		protected static $transaction  = 2;
		/**
		 * 奖金下发用户编号,用于报单中心处理
		 * @var array
		 */
		protected static $declaration = [];
		/**
		 * 查看下发状态
		 * @var unknown
		 */
		protected static $ztai = [
			'chongxioa'=>0,/** 是否有重销*/
			'jidai'=>0,/** 是否有级别服务费old*/
			'jibai'=>0,/** 是否有服务费*/
			'jibie'=>0,/** 是否有级别记录*/
		];
		/**  统一入库时间戳/日期*/
		public static $times   = 0;
		public static $ymd     = 0;
		public static $ymdh    = 0;
		/**
		 * 订单信息
		 * @var array
		 */
		public static $ids    = 0;
		/**
		 * 用户信息
		 * @var unknown
		 */
		public static $users     = [];
		/**
		 * 订单商品id用于确认类型
		 * @var unknown
		 */
		public static $dbstats   = 1;
		/**
		 * 订单商品id用于确认类型
		 * @var unknown
		 */
		public static $goodsid   = null;
		/**
		 * 用户业绩
		 * @var unknown
		 */
		public static $vipyeji     = [];
		/**
		 * 用户消费积分
		 * @var integer
		 */
		public static  $xfamount   = 0;
		/**
		 * 架构函数
		 * @access public
		 * @param  array|object $data 数据
		 */
		public function __construct($data = [])
		{
			$this->startTransaction();
			$this->uptime();
			$this->getwk();
		}
		
		public function welcome()
		{
			echo self::$times;
		}
		
		/**
		 * 开启事务
		 */
		public function startTransaction()
		{
			self::$transaction = Yii::$app->db->beginTransaction();
			self::$start = true;
		}
		
		/**
		 * 执行事务
		 */
		public function commit()
		{
			if(self::$start){
				self::$transaction->commit();
			}
		}
		
		/**
		 * 统一单次处理的编辑时间
		 */
		public function uptime()
		{
			self::$log      = [];
			self::$tdg      = [];
			self::$ly       = [];
			self::$love     = [];
			self::$fuxiao   = [];
			self::$user_row = [];
            self::$times = time();
			self::$ymd   = date("Y-m-d", self::$times);
			self::$ymdh  = date("Y-m-d H:i:s", self::$times);
			return self::$times;
		}
		
		/**
		 * 清空记录
		 */
		public function qklog()
		{
			self::$ilog = [];
			return true;
		}
		
		/**
		 * 获取用户信息
		 */
		public function getusers($loginname='')
		{
			/*if(count(self::$users) > 0){
				return true;
			}*/
			$uname = Yii::$app->session->get("loginname");
			if(!empty($loginname)){
				$uname = $loginname;
			}
			self::$users = User::findByUsername($uname);
			if(self::$users === null){
				return $this->putfile('order. not users.');
			}
			return self::$users->toArray();
		}
		
		/**
		 * 更新值
		 * @param unknown $keys
		 * @param unknown $val
		 * @return boolean|string
		 */
		public function setkeys($keys,$val,$type = false)
		{
			$keyall = array_keys(self::$users->toArray());
			if(!in_array($keys,$keyall)){
				return false;
			}
			if($type){
				self::$users[$keys]  = $val;
			}else{
				self::$users[$keys] += $val;
			}
			
			return true;
		}

		/**
		 * 是不是马芳团队
		 * @param unknown $rpath
		 */
		public function isMafang($rpath = null,$userid = 0){
		    if(empty($rpath)){
		        return true;
		    }
		    if(in_array('2684', explode(',', $rpath)) || $userid == '2684'){
		        return false;
		    }
		    return true;
		}
		
		/**
		 * 订单积分/计算奖金
		 */
		public function orderPoints($ido,$points,$type = 1)
		{
			/** 如果基本信息不全直接结束.失败*/
			if(count(self::$users) == 0){
				return false;
			}
			/** 基本参数*/
			$uname   = self::$users['loginname'];
			$points  = $this->countf($points,2);
			/** 设置下发奖金基数*/
			self::$xfamount = $points;
			self::$ids      = $ido;
			
			/** 如果没积分不处理奖金*/
			if($points <= 0 || empty(self::$users['rid'])){
				return false;
			}
			/** 等级奖先关处理*/
			$ret = $this->positionPoints($points);
			if( $ret === false){
				return $ret;
			}
			
			/** 升级时变动级别*/
			$vips   = self::$users['standardlevel'];
			self::$users['pay_points_all'] += ($type == 2?$points/2:$points);
			
			/** 三点位对推荐人加vip数量*/
			
			/** 检查等级是否存在*/
			if(!isset(self::$levels[$vips])){
				return $this->putfile('users. vips does not exist.');
			}
			$rid_row = User::findByUsername(self::$users['rid']);
			/** 设定用户模型 */
			$User = new User();
			
			if($rid_row['standardlevel'] > self::$newtjl){
				/** 检查推荐人等级是否存在*/
				if(!isset(self::$zt[$rid_row['standardlevel']])){
					return $this->putfile('users. rlevel does not exist.');
				}
				/**升级用户修改用户级别*/
				$ztall    = $points;
				$ztamount = $ztall*self::$zt[$rid_row['standardlevel']];
				
				
				/** 判断是否下发爱心基金*/
				if($rid_row['allamount']>=10000 && $this->isMafang($rid_row['rpath'],$rid_row['id'])){
					$zbl = 0.72+self::$newfx;
					$this->insaxlog($rid_row['id'],$ztamount);
				}else{
					$zbl = 0.82+self::$newfx;
				}
				/**报单奖5%*/
				$bdrid = empty($rid_row['baodan']) && !empty($rid_row['bdr']) ? $rid_row['bdr']:0;
				/** 下发推荐奖*/
				$this->instdg($rid_row['id'],$ztall,self::$zt[$rid_row['standardlevel']],$ztamount*$zbl,1,null,$bdrid);
			}
			
			/** 旅游积分 status*/
			if($type > 1){
				$pd_arr    = array();
				$rpath_arr = explode(',', self::$users['rpath']);
				foreach ($rpath_arr as $key=>$val){
					if($key > 0 && isset($rpath_arr[$key+1])){
						$pd_arr[$val] = $rpath_arr[$key+1];
					}
				}
				if(count($pd_arr) > 0){
					$row  = $User->find()->where(['in','id',$pd_arr])->andWhere(['>','standardlevel',0])->asArray()->select(['id','standardlevel'])->orderBy('id DESC')->all();
					if(!empty($row)){
						$pd_level   = [];
						foreach ($row as $v){
							$pd_level[$v['id']]=$v['standardlevel'];
						}
						$rpath_arr = array_keys($pd_arr);
						/** 排除a001*/
						if(isset($rpath_arr[0]) && $rpath_arr[0] == 1){
							unset($rpath_arr[0]);
						}
						
						if(count($rpath_arr)>0){						    
							$sql = "select `points_all` from zm_position WHERE p.`users_id` = `rid`  ORDER BY `points_all` desc limit 0,1";
							$sql = "select p.`users_id`,IFNULL(({$sql}),0) as vnum from zm_position as p where `users_id` in (".(implode(',', $rpath_arr)).") and p.`points_all` > 0 ORDER BY p.`users_id` asc";
							$row2 = Yii::$app->db->createCommand($sql)->queryAll();
							foreach ($row2 as $val){
							    if($val['vnum'] > 0){
							        $vnum2 = Yii::$app->db->createCommand("select points_all from zm_position WHERE  users_id = ".$pd_arr[$val['users_id']]." ")->queryScalar();
							        if($vnum2!== false && $vnum2 < $val['vnum']){
							            $this->insly($val['users_id'],100);
							        }
							    }
							}
						}
						
					}
				}
			}
			
			/** 调整用户积分/级别信息*/
			if(!self::$users->save()){
				$err = self::$users->getErrors();
				list($first_key, $first) = (reset($err) ? each($err) : each($err));
				return $this->putfile($first['0']);
			}
			/** 商城添加升级积分*/
			if($type==1 || $type==3){
				$rets  = Yii::$app->db->createCommand("Update ecs_users set pay_points=pay_points+".($points).",rank_points=rank_points+".($points)." where user_name = '".self::$users['loginname']."'")->execute();
				if(empty($rets) || $rets === false){
					return Yii::$app->mycomponent->pr(['status' => 2, 'msg' => '商城积分修改失败']);
				}
			}
			/** 累计推荐人的业绩*/
			$rets  = Yii::$app->db->createCommand("Update zm_position set points_all=points_all+$points where users_id in (" . self::$users['rpath'] . ")")->execute();
			if(empty($rets) || $rets === false){
				return $this->putfile('order. up position points.');
			}
			/** */
			$rets  = Yii::$app->db->createCommand("Update zm_position set points_old=points_old+".($type==2?$points/2:$points)." where users_id = ".self::$users['id'])->execute();
			if(empty($rets) || $rets === false){
				return $this->putfile('order. up position points.');
			}
			if($type > 1){
				/** 代理费*/
				if(!empty(self::$users['baodan']) && isset(self::$levels[$vips])){
					$baodan = User::findByUsername(self::$users['baodan']);
					if(isset($baodan['id']) && $baodan['status'] == 1 && $baodan['dllevel'] == 1){
						$this->instdg($baodan['id'],$points,0.05,$points*0.05*0.92,5,null,$baodan['id']);
					}
				}
				/** 服务费*/
				if(empty(self::$users['baodan'])&& !empty(self::$users['bdr']) && isset(self::$levels[$vips])){
				    $baodan = User::findByUsername(self::$users['bdr']);
				    if(isset($baodan['id']) && $baodan['status'] == 1 && $baodan['bdl'] == 1){
				        $this->instdg($baodan['id'],$points,0.05,$points*0.05*0.92,6,null,$baodan['id']);
				    }
				}
			}
			if($type == 3 ){
				$rets  = Yii::$app->db->createCommand("Update zm_position set r_vip_num=r_vip_num+1 where users_id in (".self::$users['rpath'] .")")->execute();
				if(empty($rets) || $rets === false){
					return $this->putfile('order. up position r_vip_num.');
				}
			}
			
			$week = self::$curwk;
			$plvs      = ['1' => [],'2' => []];
			$i         = 0;
			$dpamount = 0;
			$upwhere   = "";
			$area      = self::$users['area'];
			$p_row     = $User->find()->from('users as u')->leftJoin('zm_position as p','u.`id` = p.`users_id`')->where(['in','u.`id`',explode(',', self::$users['ppath'])])->asArray()
				->select(['u.`id`','u.`cx_vipyeji1`','u.`cx_vipyeji2`','u.`allamount`','u.`area`','u.`rpath`','u.`loginname`','u.`standardlevel`',"p.`f$week`",'u.`bdr`','u.`baodan`','p.`abs_area`','p.`absolute`'])->orderBy('ceng DESC')->all();
			foreach ($p_row as $row12) {
				$dpamount = self::$xfamount;
				$isobs     = 0;
				$obsamount = 0;
				/** 判断是否*/
				if($area <= 0){
					continue;
				}
				if($row12['standardlevel']>0){
					$plvs[$area][] = $row12['id'];
					/** 判断订单所有者是否有级别*/
					if($vips <= 0){
						continue;
					}
					
					$Aone = "cx_vipyeji" . $area;
					$Atow = $area == 1 ? "cx_vipyeji2" : "cx_vipyeji1";
					
					/*左区绝对碰*/
					if($area==1 && $row12['abs_area']==1 && $row12['absolute']>0){
						if($row12['cx_vipyeji2'] <= $row12['cx_vipyeji1']){
							$obsamount = $row12['cx_vipyeji2'];
							$row12['cx_vipyeji2'] += $row12['absolute'];
							$isobs = 1;
						}
//			    echo 1;die;
					}
					/*右区绝对碰*/
					else if($area==2 && $row12['abs_area']==2 && $row12['absolute']>0){
						if($row12['cx_vipyeji1'] <= $row12['cx_vipyeji2']){
							$obsamount = $row12['cx_vipyeji1'];
							$row12['cx_vipyeji1'] += $row12['absolute'];
							$isobs = 1;
						}
					}
					if ($row12[$Aone] < $row12[$Atow] && $row12[$Atow] > 0) {
						$nowyeji = -1;
						if ($row12[$Aone] + self::$xfamount >= $row12[$Atow]) {
							if($isobs==1){
								$obsyeji = 0;
							}
							$nowyeji = $row12[$Aone] + $dpamount - $row12[$Atow];
							$dpamount = $row12[$Atow];
							$newOne = $Aone == 'cx_vipyeji1' ? 'cx_vipyeji1' : 'cx_vipyeji2';
							$newTow = $Aone == 'cx_vipyeji1' ? 'cx_vipyeji2' : 'cx_vipyeji1';
						} elseif ($row12[$Aone] + $dpamount < $row12 [$Atow]) {
							if($isobs==1){
								$nowyeji = $obsamount>($row12[$Aone] + $dpamount)?$obsamount-$row12[$Aone]-$dpamount:0;
								$obsyeji = $nowyeji > 0 ? $row12['absolute'] : $row12[$Atow] - $row12[$Aone] - $dpamount;
								if($obsamount>0){
									$dpamount = $obsamount>($row12[$Aone] + $dpamount)?$row12[$Aone]+$dpamount:$obsamount;
								}
							}else{
								$nowyeji = $row12[$Atow] - $dpamount - $row12[$Aone];
							}
							$newOne = $Atow == 'cx_vipyeji2' ? 'cx_vipyeji2' : 'cx_vipyeji1';
							$newTow = $Atow == 'cx_vipyeji2' ? 'cx_vipyeji1' : 'cx_vipyeji2';
						}
						
						/** 修改拿对碰的人的有效大小区*/
						$query  = Yii::$app->db->createCommand("update users set ".$newOne."=".$nowyeji.",".$newTow."=0 where loginname='".$row12['loginname']."'")->execute();
						if(($nowyeji>0 && empty($query)) || $query === false){
							return $this->putfile('users. update yeji no.');
						}
						/** 修改绝对碰的人的有效对碰数值*/
						if($isobs==1){
							if($obsyeji>0){
								$query  = Yii::$app->db->createCommand("update zm_position set `absolute`=".$obsyeji." where uname='".$row12['loginname']."'")->execute();
							}else{
								$query  = Yii::$app->db->createCommand("update zm_position set `absolute`=".$obsyeji.",`abs_area`= 0 where uname='".$row12['loginname']."'")->execute();
							}
							if($query === false){
								return $this->putfile('users. update jueduiyeji no.');
							}
						}
						if(empty($query) || $query === false){
							return $this->putfile('users. update yeji no.');
						}
						$yqamout = $dpamount * self::$xs[$row12['standardlevel']];
						$integral = self::$levels[$row12['standardlevel']]['limitintegral'];
						if($row12['f'.$week]+$yqamout>$integral) {
							if($row12['f'.$week]<$integral){
								$yqamout = ($integral-$row12['f'.$week]);
								$dpamount = $yqamout/self::$xs[$row12['standardlevel']];
								
							}else{
								continue;
							}
						}
						
						if ($nowyeji >= 0 && $i <= 3) {
							/** 是否下发爱心基金*/
							if ($row12['allamount'] >= 10000 && $this->isMafang($row12['rpath'],$row12['id'])) {
								$dbl = 0.72+self::$newfx;
								$this->insaxlog($row12['id'],$yqamout);
							}else{
								$dbl = 0.82+self::$newfx;
							}
							if(!isset(self::$xs[$row12['standardlevel']])){
								return $this->putfile($row12['id'].'users. vips does not exist.');
							}
							/**报单奖5%*/
							$bdrid = empty($row12['baodan']) && !empty($row12['bdr']) ? $row12['bdr']:0;
							/** 下发销售奖*/
							$this->instdg($row12['id'],$dpamount,self::$xs[$row12['standardlevel']],$yqamout*$dbl,2,null,$bdrid);
							/** 对拼记录*/
							if($isobs==1) {
								if($area==1){
									$lp = $row12['cx_vipyeji1'];
									$rp = $obsamount;
								}elseif ($area==2){
									$lp = $obsamount;
									$rp = $row12['cx_vipyeji2'];
								}
								$this->inslog($row12['id'],$lp,$rp,$dpamount,1);
							}else{
								$this->inslog($row12['id'],$row12['cx_vipyeji1'],$row12['cx_vipyeji2'],$dpamount);
							}
							$r_row = $User->find()->where(['in','id',explode(',', $row12['rpath'])])->andWhere(['>','standardlevel',0])->asArray()
								->select(['id','allamount','loginname','bdr','baodan','rpath'])->orderBy('dai DESC')->limit(3)->all();
							$j=1;
							foreach ($r_row as $vvlue){
								if($j < 3)
									$glamount = $yqamout* self::$gl[$j];
								if($vvlue['allamount']>=10000 && $this->isMafang($vvlue['rpath'],$vvlue['id'])){
									/** 预留爱心基金的记录*/
									$gbl = 0.72+self::$newfx;
									$this->insaxlog($vvlue['id'],$glamount,$row12['id']);
								}else{
									$gbl = 0.82+self::$newfx;
								}
								/**报单奖5%*/
								$bdrid = empty($vvlue['baodan']) && !empty($vvlue['bdr']) ? $vvlue['bdr']:0;
								$this->instdg($vvlue['id'],$yqamout,self::$gl[$j],$glamount*$gbl,3,$row12['id'],null,$bdrid);
								$j++;
							}
							$i++;
						}else {
							$query  = Yii::$app->db->createCommand("update users set ".$newOne."=".$nowyeji.",".$newTow."=0 where loginname='".$row12['loginname']."'")->execute();
							if($query === false){
								return $this->putfile('users. update yeji no.');
							}
						}
					}else if($row12[$Aone] >= $row12[$Atow] && $row12[$Aone] >= 0){
						if($this->updatevipyeji($row12['id'], $Aone)===false){
							return false;
						}
					}
				}
				
				$area = $row12['area'];
			}
			/**用于计算剩余的不满足1000条的**/
			if($this->updatevipyeji()===false){
				return false;
			}
			
			if(self::$sets){
				/** 获取获奖人员的报单中心*/
				$duser  = [];
				$baoarr = [];
				if(count(self::$declaration) > 0){
					$duser = $User->find()->where(['in','`loginname`',self::$declaration])->andWhere(['=','`status`',1])->andWhere(['=','`bdl`',1])->asArray()->select(['`id`','`loginname`'])->orderBy('`id` ASC')->all();
					if(is_array($duser) && count($duser) > 0){
						foreach ($duser as $val){
							$baoarr[$val['loginname']] = $val['id'];
						}
					}
					foreach (self::$tdg as $key =>$val){
						if($val['type'] < 5){
							if(isset($baoarr[$val['declaration']])){
								self::$tdg[$key]['declaration'] = $baoarr[$val['declaration']];
							}else{
								self::$tdg[$key]['declaration'] = 0;
							}
						}
					}
				}
				/** 下发奖金*/
				$ret = $this->insertall(self::$tdg,'zm_tdgjj');
				if($ret === false){
					return $ret;
				}
				/** 爱心基金*/
				$ret = $this->insertall(self::$love,'zm_lovefund');
				if($ret === false){
					return $ret;
				}
				/** 记录对拼*/
				$ret = $this->insertall(self::$log,'zm_tdglog');
				if($ret === false){
					return $ret;
				}
				/** 下发旅游*/
				$ret = $this->insertall(self::$ly,'zm_travel');
				if($ret === false){
					return $ret;
				}
			}
			
			/** 累计业绩*/
			if(count($plvs[1]) > 0){
				$que  = Yii::$app->db->createCommand("update users set lallyeji=lallyeji+".$points." where id in (".implode(",", $plvs[1]).")")->execute();
				if(empty($que) || $que === false){
					return $this->putfile('lallyeji update users 1.');
				}
			}
			if(count($plvs[2]) > 0){
				$que  = Yii::$app->db->createCommand("update users set rallyeji=rallyeji+".$points." where id in (".implode(",", $plvs[2]).")")->execute();
				if(empty($que) || $que === false){
					return $this->putfile('lallyeji update users 2.');
				}
			}
			
			/** 下发销售到结算表*/
			if(count(self::$tdg) >0){
				$sql = "SELECT t.`userid`,SUM(t.`bonus`) AS zong ,SUM(if(t.`type`<5,t.`points`*t.`pre`*".(0.1-self::$newfx).",0)) AS fxzong FROM zm_tdgjj AS t WHERE t.`type` in(1,2,3) AND t.`status` in(1,2) AND t.`orderid` = ".(self::$ids*-1)." GROUP BY userid ";
				$up  = Yii::$app->db->createCommand("UPDATE zm_position AS l INNER JOIN({$sql}) c SET l.`$week`=l.`$week`+c.zong , l.`v$week`=l.`v$week`+c.fxzong WHERE l.`users_id` = c.`userid`")->execute();
				if(empty($up) || $up === false){
					return $this->putfile('lallyeji update users.');
				}
			}
			
			/** 统计封顶*/
			if(self::$ztai['chongxioa'] > 0){
				$sql = "SELECT t.`userid`,SUM(t.`points`* t.`pre`) AS zong FROM zm_tdgjj AS t WHERE t.`status` in(1,2) AND t.`type` = 2 AND t.`orderid` = ".(self::$ids*-1)." GROUP BY userid ";
				$up  = Yii::$app->db->createCommand("UPDATE zm_position AS l INNER JOIN({$sql}) c SET l.`f$week`=l.`f$week`+c.zong WHERE l.`users_id` = c.`userid`")->execute();
				if(empty($up) || $up === false){
					return $this->putfile('lallyeji update users.');
				}
			}
			/** 下发等级奖到结算表*/
			if(self::$ztai['jibie'] > 0){
				$sql = "SELECT p.`userid`,SUM(p.`bonus`) AS zong ,SUM(p.`points` * p.`pre` * ".(0.1-self::$newfx).") AS fxzong FROM zm_position_points AS p WHERE p.`type` = 0 AND p.`status` = 1 AND p.`orderid` = ".(self::$ids*-1)." GROUP BY userid ";
				$up  = Yii::$app->db->createCommand("UPDATE zm_position AS l INNER JOIN({$sql}) c SET l.`p$week`=l.`p$week`+c.zong , l.`v$week`=l.`v$week` + c.fxzong WHERE l.`users_id` = c.`userid`")->execute();
				if(empty($up) || $up === false){
					return $this->putfile('lallyeji update users 2.');
				}
			}
			/** 下发代理费/服务费*/
			if(self::$ztai['jibai'] > 0){
				/** 销售奖报单提*/
				$sql = "SELECT t.`declaration`,SUM(t.`bonus`) AS bdzong FROM zm_tdgjj AS t WHERE t.`type` in(5,6) AND t.`status` in(1,2) AND t.`orderid` = ".(self::$ids*-1)." AND t.`declaration` > 0 GROUP BY t.`declaration` ";
				$up  = Yii::$app->db->createCommand("UPDATE zm_position AS l INNER JOIN({$sql}) c SET l.`b$week`=l.`b$week`+c.bdzong WHERE l.`users_id` = c.`declaration`")->execute();
				if(empty($up) || $up === false){
					return $this->putfile('lallyeji update users bd.');
				}
			}
			/** 下发等级奖到结算表--废弃
			if(self::$ztai['jidai'] > 0){
				$sql = "SELECT p.`declaration`,SUM(p.`bonus`) AS bdzong FROM zm_position_points AS p WHERE p.`type` = 0 AND p.`status` = 1 AND p.`orderid` = ".(self::$ids*-1)." AND p.`declaration` > 0 GROUP BY p.`declaration` ";
				$up  = Yii::$app->db->createCommand("UPDATE zm_position AS l INNER JOIN({$sql}) c SET l.`b$week`=l.`b$week`+c.bdzong WHERE l.`users_id` = c.`declaration`")->execute();
				if(empty($up) || $up === false){
					return $this->putfile('lallyeji update users 2 bd .');
				}
			}*/
			return true;
		}
		
		/**
		 * 更新用户vip业绩
		 * @param number $id
		 * @param number $keys
		 * @return string|boolean
		 */
		public function updatevipyeji($id=0,$keys=0){
			if($id>0){
				self::$vipyeji[$keys][]=$id;
				if(count(self::$vipyeji[$keys])>=1000){
					$que  = Yii::$app->db->createCommand("update users set $keys=$keys+". self::$xfamount." where id in(".implode(',',self::$vipyeji[$keys]).")")->execute();
					if(empty($que) || $que === false){
						return $this->putfile('i>3 update users1.');
					}
					/**执行完毕后，清空**/
					self::$vipyeji[$keys]=[];
				}
			}else{
				foreach(self::$vipyeji as $key=>$val){
					$que  = Yii::$app->db->createCommand("update users set $key=$key+". self::$xfamount." where id in(".implode(',',$val).")")->execute();
					if(empty($que) || $que === false){
						return $this->putfile('i>3 update users2.');
					}
				}
				/**执行完毕后，清空**/
				self::$vipyeji=null;
			}
			return true;
		}
		
		/**
		 * h获取订单商品编号
		 * @param unknown $orderid
		 * @return string|boolean
		 */
		public function getgoodsid($orderid){
			self::$goodsid = $GLOBALS ['db']->getOne("SELECT goods_id  FROM " . $GLOBALS ['ecs']->table ( 'order_goods' ) . " WHERE order_id = '$orderid' limit 0,1");
			if(self::$goodsid === false){
				return $this->putfile('order. not goods.');
			}
			return true;
		}
		
		/**
		 * 等级奖
		 * @param unknown $points
		 * @return boolean
		 */
		public function positionPoints($points){
			
			/** 如果为空不做处理*/
			if(empty(self::$users['rpath'])){
				return true;
			}
			/** 获取所以推荐节点人关系 */
			
			$ruser = Yii::$app->db->createCommand("SELECT zmp.id,zmp.users_id,u.allamount,u.rpath,zmp.level,zmp.rid  FROM zm_position as zmp LEFT JOIN users as u ON u.id=zmp.users_id WHERE ((zmp.level > 0 AND zmp.level < 13) AND zmp.users_id in(".self::$users['rpath'].") AND zmp.status = 1) OR zmp.users_id = '".self::$users['id']."' ORDER BY zmp.users_id DESC limit 0,10000")->queryAll();
			if(count($ruser) == 0){
				return $this->putfile('order. not rpath.');
			}
			
			/** 倒叙推荐人关系*/
			$rpath = explode(',', self::$users['rpath']);
			$rpath[] = self::$users['id'];
			$rpath = array_reverse($rpath);
			$rdata = [];
			$position = [];
			/** 格式化推荐人队列关系*/
			foreach ($ruser as $val){
				if($val['users_id'] == self::$users['id']){
					$position = $val;
					if($val['level'] <= 0){
					    continue;
					}
				}
				$rdata[$val['users_id']] = $val;
			}
			unset($ruser);
			
			/** 准备发放奖金的用户关系*/
			$bouns = [];
			/** 等级奖*/
			$levels= [];
			$levnum= 13;
			foreach ($rpath as $val){
				if(isset($rdata[$val])){
					if(!isset($bouns[$rdata[$val]['level']]) && $rdata[$val]['level'] < $levnum){
						$levels[$rdata[$val]['level']] = $rdata[$val];
						$levnum = $rdata[$val]['level'];
					}
					$bouns[$rdata[$val]['level']][] = $rdata[$val];
				}
			}
			/** 计算奖金*/
			$pre    = 0;
			$posarr = [];
			$uids   = [];
			$uido   = [];
			foreach (self::$level as $key => $val){
				if(isset($levels[$key])){
					$levels[$key]['pre']    = $val['bonus']-$pre;
					$levels[$key]['points'] = $points * $levels[$key]['pre']/100;
					if ($levels[$key]['allamount'] >= 10000 && $this->isMafang($levels[$key]['rpath'],$levels[$key]['users_id'])) {
						$jbl = 0.72+self::$newfx;
						$this->insaxlog($levels[$key]['users_id'],$this->countf($points * $levels[$key]['pre']/100));
					}else{
						$jbl = 0.82+self::$newfx;
					}
					$levels[$key]['bonus']  = $this->countf($points * $levels[$key]['pre']*$jbl/100);
					$pre = $val['bonus'];
					$posarr[] = [
						'userid' => $levels[$key]['users_id'],
						'points' => $this->countf($points),
						'pre' => $levels[$key]['pre']/100,
						'bonus' => $levels[$key]['bonus'],
						'orderid' => (self::$ids*-1),
						'reason' => self::$users['id'],
					    'dai' => 0,
						'type' => 0,
						'addtime' => self::$times,
						'status' => 1,
						'declaration' => 0,
					];
					$uids[]   = $levels[$key]['users_id'];
					$uido[$levels[$key]['users_id']] = $levels[$key];
				}
			}
			/** 报单奖金处理*/
			$declaration = $uids;
			/** 级差奖*/
			$leveldiff = [];
			/** 获取极差来源人的代数*/
			foreach ($uido as $key => $val){
			    if(isset($bouns[$val['level']])){
			        $ik = 0;
			        foreach ($bouns[$val['level']] as $keys => $vals){
			            if($vals['users_id'] != $key && $ik < 2){
			                $leveldiff[] = $val['users_id'];
			                $ik++;
			            }
			        }
			    }
			}
			$levellai = [];
			if(count($leveldiff) > 0){
			    $levus  = [];
			    $lsuser = Yii::$app->db->createCommand("SELECT `id`,`dai` FROM users WHERE `id` in(".(implode(',', $leveldiff)).") AND `status` = 1 ORDER BY `id` DESC limit 0,10000")->queryAll();
			    foreach ($lsuser as $val){
			        if(isset($val['id'])){
			            $levus[$val['id']] = $val['dai'];
			        }
			    }
			    foreach ($uido as $key => $val){
			        if(isset($bouns[$val['level']])){
			            $ik = 0;
			            foreach ($bouns[$val['level']] as $keys => $vals){
			                if($vals['users_id'] != $key && $ik < 2){
				                if ($vals['allamount'] >= 10000 && $this->isMafang($vals['rpath'],$vals['users_id'])) {
					                $jcbl = 0.72+self::$newfx;
					                $this->insaxlog($vals['users_id'],$val['points']*0.1,$val['users_id'],1);
				                }else{
					                $jcbl = 0.82+self::$newfx;
				                }
				                $posarr[] = [
					                'userid' => $vals['users_id'],
					                'points' => $val['points'],
					                'pre' => 0.1,
					                'bonus' => $this->countf($val['points']* $jcbl * 0.1),
					                'orderid' => (self::$ids*-1),
					                'reason' => $val['users_id'],
					                'dai' => (isset($levus[$val['users_id']])?$levus[$val['users_id']]:0),
					                'type' => 1,
					                'addtime' => self::$times,
					                'status' => 2,
					                'declaration' => 0,
				                ];
				                $levellai[] = $vals['users_id'];
				                $ik++;
			                }
			            }
			        }
			    }
			}
			
			/** 获取获奖人员的报单中心 */
			$duser= [];
			if(count($declaration) > 0){
				$duser = Yii::$app->db->createCommand("SELECT u.`bdr`,u.`id`,u2.`id` as bid FROM users AS u LEFT JOIN users AS u2 ON u.`bdr` = u2.`loginname` WHERE u.`id` in(".(implode(',', $declaration)).") AND u.`status` = 1 AND (u.`baodan` = '' OR u.`baodan` IS NULL) AND u.`bdr` != '' ORDER BY u.`id` DESC limit 0,10000")->queryAll();
				if(is_array($duser) && count($duser) > 0){
					$baoarr = [];
					foreach ($duser as $val){
						$baoarr[$val['id']] = $val['bid'];
					}
					foreach ($posarr as $key =>$val){
						if(isset($baoarr[$val['userid']])){
							$posarr[$key]['declaration'] = $baoarr[$val['userid']];
							self::$ztai['jidai'] += 1;
						}
					}
				}
				/** 记录推荐人是否拿到级别奖*/
				$week = self::$curwk;
				$query = Yii::$app->db->createCommand("update zm_position set `s$week`=IF(`s$week` <0,1,`s$week`+1) where `users_id` in(".self::$users['rpath'].",".self::$users['id'].") AND `rid` in(".implode(',', $declaration).") AND `users_id` > 1")->execute();
				if($query === false){
				    return $this->putfile('order. not rpath.');
				}
				if(count($levellai) > 0){
				    $query = Yii::$app->db->createCommand("update zm_position set `s$week`=`s$week`-1 where `users_id` in(".self::$users['rpath'].",".self::$users['id'].") AND `rid` in(".implode(',', $levellai).") AND `users_id` > 1 AND `s$week` = 0")->execute();
				    if($query === false){
				        return $this->putfile('order. not rpath.');
				    }
				}
			}
			self::$ztai['jibie'] = count($posarr);
			return $this->insertall($posarr,'zm_position_points');
		}
		
		/**
		 * 对拼奖金记录
		 * @param unknown $userid
		 * @param unknown $left
		 * @param unknown $right
		 * @param unknown $bump
		 * @return string|boolean
		 */
		public function inslog($userid,$left,$right,$bump,$types=2)
		{
			$data = array(
				"userid"    =>  $userid,
				"lefts"     =>  $left*1,
				"rights"    =>  $right*1,
				"bump"      =>  $bump,
				"orderid"   =>  (self::$ids*-1),
				"reason"    =>  self::$users['id'],
				"types"     =>  $types,
				"addtime"   =>  self::$times,
				"status"    =>  self::$cxtype,
			);
			if(self::$sets){
				self::$log[] = $data;
			}else{
				$que = Yii::$app->db->createCommand()->insert('zm_tdglog', $data)->execute();
				if(empty($que) || $que === false){
					return $this->putfile('order. not zm_tdglog.');
				}
			}
			return true;
		}
		
		/**
		 * 奖金记录
		 * @param unknown $userid
		 * @param unknown $points
		 * @param unknown $pre
		 * @param unknown $bonus
		 * @param unknown $type
		 * @return string|boolean
		 */
		public function instdg($userid,$points,$pre,$bonus,$type,$reason = null,$bdrid = 0)
		{
			if(empty($reason)){
				$reason = self::$users['id'];
			}
			if(!empty($bdrid) && $type < 5){
				self::$declaration[] = $bdrid;
			}
			$data = array(
				"userid"    =>  $userid,
				"points"    =>  $this->countf($points),
				"pre"       =>  $pre,
				"bonus"     =>  $this->countf($bonus),
				"orderid"   =>  (self::$ids*-1),
				"reason"    =>  $reason,
				"type"      =>  $type,
				"addtime"   =>  self::$times,
				"status"    =>  self::$cxtype,
				'declaration' => (empty($bdrid)?0:$bdrid),
			);
			/** 记录状态*/
			if($type == 2){
				self::$ztai['chongxioa'] += 1;
			}
			if(in_array($type, [5,6])){
				self::$ztai['jibai'] += 1;
			}
			if(self::$sets){
				self::$tdg[] = $data;
			}else{
				if(!empty($bdrid)){
					if($type < 5){
						$baodan = User::findByUsername($bdrid);
						if(isset($baodan['id']) && $baodan['status'] == 1 && $baodan['bdl'] == 1){
							$data['declaration'] = $baodan['id'];
						}else{
							$data['declaration'] = 0;
						}
					}
				}else{
					$data['declaration'] = 0;
				}
				$que = Yii::$app->db->createCommand()->insert('zm_tdgjj', $data)->execute();
				if(empty($que) || $que === false){
					return $this->putfile('order. not zm_tdgjj.');
				}
			}
			return true;
		}
		
		/**
		 * 奖金记录
		 * @param unknown $userid
		 * @param unknown $points
		 * @return string|boolean
		 */
		public function insly($userid,$points)
		{
			$data = array(
				"userid"    =>  $userid,
				"points"    =>  $points,
				"orderid"   =>  (self::$ids*-1),
				"reason"    =>  self::$users['id'],
				"addtime"   =>  self::$times,
				"status"    =>  self::$cxtype,
			);
			if(self::$sets){
				self::$ly[] = $data;
			}else{
				$que = Yii::$app->db->createCommand()->insert('zm_travel', $data)->execute();
				if(empty($que) || $que === false){
					return $this->putfile('order. not zm_travel.');
				}
			}
			return true;
		}
		
		/**
		 * 下发爱心基金记录
		 * @param unknown $userid
		 * @param unknown $amount
		 */
		public function insaxlog($userid,$amount,$reason = null,$type = 0)
		{
			if(empty($reason)){
				$reason = self::$users['id'];
			}
			$data = array(
				"userid"    =>  $userid,
				"amount"    =>  $this->countf($amount),
				"love"      =>  $this->countf($amount*0.1),
				"orderid"   =>  (self::$ids*-1),
				"reason"    =>  $reason,
				"addtime"   =>  self::$times,
				"status"    =>  1,
				"type"      =>  intval($type),
			);
			if(self::$sets){
				self::$love[] = $data;
			}else{
				$que = Yii::$app->db->createCommand()->insert('zm_lovefund', $data)->execute();
				if(empty($que) || $que === false){
					return $this->putfile('zm_tdgjj. not zm_lovefund.');
				}
			}
			return true;
		}
		
		/**
		 * 记录入库
		 * @param unknown $posarr
		 * @param unknown $table
		 * @return boolean|string
		 */
		public function insertall($posarr,$table){
			/** 需要写入的记录非空*/
			if(count($posarr) <= 0){
				return true;
			}
			/** 入库*/
			$poskey = array_keys($posarr[0]);
			$data   = [];
			$num    = 1;
			$allnum = count($posarr);
			foreach ($posarr as $val){
				/** 多条同时写入*/
				if(self::$sets){
					$data[] = $val;
					if($num%3 == 0 || $allnum == $num){
						$ret = Yii::$app->db->createCommand()->batchInsert($table, $poskey, $data)->execute();
						if(empty($ret) || $ret === false){
							return $this->putfile('order. not position.');
							break;
						}
						$data = [];
					}
					$num++;
				}else{
					/** 单条写入*/
					$ret = Yii::$app->db->createCommand()->insert($table, $val)->execute();
					if(empty($ret) || $ret === false){
						return $this->putfile('order. not position 2.');
						break;
					}
				}
			}
			return true;
		}
		
		/**
		 * 写入日志
		 * @param unknown $val 描述
		 * @param string $ret 结束状态
		 * @return string
		 */
		public function putfile($val,$ret = false)
		{
			/** 结束事务*/
			if(!$ret){
				self::$transaction->rollback();
				self::$start = false;
			}
			/** 验证日志非空*/
			if(empty($val)){
				return $ret;
			}
			/** 验证文件目录是否存在*/
			$dir  = __DIR__.'/../runtime/logs/';
			$file = $dir.'one'.(date('Y_m',time())).'.txt';
			if(!is_dir($dir)){
				@mkdir($dir, 0777, true);
			}
			$contont = '';
			if(file_exists($file)){
				$contont = @file_get_contents($file);
			}
			$contont .= date('Y-m-d H:i:s',time()).' '.$val.' -ou'.(isset(self::$users['id'])?self::$users['standardlevel']:'')."\n";
			@file_put_contents($file, $contont);
			return $ret;
		}
		
		/**
		 * 读取当前周的wk
		 * @return string|boolean
		 */
		public function getwk()
		{
			$week = new ZmWeek();
			$data = $week->find()->where(['<=','stime',self::$times])->andWhere(['>=','etime',self::$times])->asArray()->one();
			if(empty($data) || $data === false){
				return $this->putfile('order. not curwk.');
			}
			self::$curwk = $data['curwk'];
			return true;
		}
		
		/**
		 * 格式金额
		 * @param unknown $num
		 */
		public function countf($num,$len = 3){
			if(!is_int($num)){
				if($len == 3){
					$num = sprintf("%.3f",substr(sprintf("%.5f", $num), 0, -2));
				}else{
					$num = sprintf("%.2f",substr(sprintf("%.4f", $num), 0, -2));
				}
			}
			return $num;
		}
		
		/**
		 * 输出
		 * @param unknown $arr
		 * @param number $type
		 * @param string $ret 正常结束不执行事务回滚
		 */
		public function pr($arr, $type = 1,$ret = false) {
			if($type == 1){
				if(!is_array($arr)){
					$arr = [$arr];
				}
				/** 结束事务*/
				if(!$ret && isset($arr['status']) && ($arr['status'] == 2 || $arr['status'] == 3)){
					self::$transaction->rollback();
					self::$start = false;
				}
				if(isset($arr['put'])){
					$this->putfile($arr['put'],true);
				}
				
				if($arr['status'] > -1 && isset($_SESSION['is_rd'])){
					unset($_SESSION['is_rd']);
				}
				return $arr;
			}else{
				echo '<pre>';
				print_r($arr);
			}
			return true;
		}
	}
