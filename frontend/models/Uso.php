<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "users".
 * 新增用户 模型，专用
 *
 * @property integer $id
 * @property string $pid
 * @property string $rid
 * @property string $loginname
 * @property integer $standardlevel
 * @property integer $ystandardlevel
 * @property integer $newstandardlevel
 * @property string $pwd1
 * @property string $pwd2
 * @property string $pwd3
 * @property string $zhengshuid
 * @property integer $states
 * @property string $truename
 * @property string $address
 * @property string $identityid
 * @property string $bank
 * @property string $bankno
 * @property string $bankname
 * @property string $bankaddress
 * @property string $tel
 * @property string $qq
 * @property string $addtime
 * @property string $adddate
 * @property string $jihuotime
 * @property string $amount
 * @property string $inputamount
 * @property integer $area
 * @property string $yeji1
 * @property string $yeji2
 * @property integer $num1
 * @property integer $num2
 * @property string $allyeji1
 * @property string $allyeji2
 * @property string $allyouxiaoyeji1
 * @property string $allyouxiaoyeji2
 * @property integer $dai
 * @property integer $ceng
 * @property integer $lockuser
 * @property string $pic
 * @property integer $bd
 * @property string $baodan
 * @property string $ppath
 * @property string $rpath
 * @property string $pay_points
 * @property string $pay_points_all
 * @property integer $sheng
 * @property integer $shi
 * @property integer $xian
 * @property string $aixinjijin
 * @property integer $yuanshigu
 * @property string $ysg_count
 * @property string $dl_money
 * @property string $dl_money_count
 * @property string $yyaxjj
 * @property integer $dllevel
 * @property integer $ffyuanshigu
 * @property string $isjiangli
 * @property string $commission
 * @property string $principal
 * @property string $dlno
 * @property string $newyouxiaoyeji1
 * @property string $newyouxiaoyeji2
 */
class Uso extends \yii\db\ActiveRecord
{
    public $status_code=0;
    public $fuwuuser='';
    public $uids=0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $where = array();
        if($this->status_code==1){
            $where = [[ 'bankno', 'bankname','identityid'], 'required'];
        }else if($this->status_code==2){
            $where = [['pid', 'rid', 'loginname','pwd1'], 'required'];
        }else{
            $where = [['pid', 'rid', 'loginname','pwd1','tel','truename','identityid'], 'required'];
        }
        return [
            $where,
            [['standardlevel', 'ystandardlevel', 'newstandardlevel', 'states', 'area', 'num1', 'num2', 'dai', 'ceng', 'lockuser', 'bd', 'sheng', 'shi', 'xian', 'yuanshigu', 'ysg_count', 'dllevel', 'ffyuanshigu', 'isjiangli'], 'integer'],
            [['addtime', 'adddate', 'jihuotime'], 'safe'],
            [['amount', 'inputamount', 'yeji1', 'yeji2', 'allyeji1', 'allyeji2', 'allyouxiaoyeji1', 'allyouxiaoyeji2', 'pay_points', 'pay_points_all', 'aixinjijin', 'dl_money', 'dl_money_count', 'yyaxjj', 'commission', 'principal', 'newyouxiaoyeji1', 'newyouxiaoyeji2'], 'number'],
            [['ppath', 'rpath'], 'string'],
            [['pid', 'rid', 'zhengshuid', 'truename', 'address', 'identityid', 'bank', 'bankno', 'bankname', 'bankaddress', 'tel', 'qq', 'pic', 'baodan','dlno'], 'string', 'max' => 35],
            [['pwd1', 'pwd2', 'pwd3'], 'string', 'max' => 32],
            ['loginname', 'string', 'max' => 20],
            [['loginname'], 'unique'],
            [['pid', 'area'], 'unique', 'targetAttribute' => ['pid', 'area'], 'message' => '每个人左区和右区只能安置一个人！'],
            [['rid','pid'],'match', 'pattern'=>"/^[a-zA-Z_\\d]+$/u", 'message'=> '{attribute}无效，格式错误！'],
            [['loginname','baodan'],'match', 'pattern'=>"/^[a-zA-Z\\d]+$/u", 'message'=> '{attribute}无效，格式错误！'],
            [['bank'],'match', 'pattern'=>"/^[\x{4e00}-\x{9fa5}.]+$/u", 'message'=> '请选择开户行'],
	        ['tel','match', 'pattern'=>"/^1[3,4,5,6,7,8,9]{1}[\d]{9}$/u", 'message'=> '{attribute}格式错误，请重新输入！'],
            [['pwd1','pwd2'],'match', 'pattern'=>"/^[!\"#$%&'()*+,-.\/:;<=>?@[\\]^_'{|}~A-Za-z\\d]+$/u", 'message'=> '{attribute}无效，格式错误！'],
            ['addtime', 'default', 'value' => date("Y-m-d H:i:s",time())],
            ['adddate', 'default', 'value' => date("Y-m-d",time())],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'pid' => '安置人',
            'rid' => '邀请人',
            'loginname' => '用户名',
            'standardlevel' => '等级',
            'ystandardlevel' => 'Ystandardlevel',
            'newstandardlevel' => 'Newstandardlevel',
            'pwd1' => '密码',
            'pwd2' => '二级密码',
            'pwd3' => 'Pwd3',
            'zhengshuid' => 'Zhengshuid',
            'states' => 'States',
            'truename' => '真实姓名',
            'address' => '详细地址',
            'identityid' => '身份证号',
            'bank' => '开户行',
            'bankno' => '银行卡号',
            'bankname' => '真实姓名',
            'bankaddress' => '开户地址',
            'tel' => '手机',
            'qq' => '电子邮箱',
            'addtime' => 'Addtime',
            'adddate' => 'Adddate',
            'jihuotime' => 'Jihuotime',
            'amount' => 'Amount',
            'inputamount' => 'Inputamount',
            'area' => 'Area',
            'yeji1' => 'Yeji1',
            'yeji2' => 'Yeji2',
            'num1' => 'Num1',
            'num2' => 'Num2',
            'allyeji1' => 'Allyeji1',
            'allyeji2' => 'Allyeji2',
            'allyouxiaoyeji1' => 'Allyouxiaoyeji1',
            'allyouxiaoyeji2' => 'Allyouxiaoyeji2',
            'dai' => 'Dai',
            'ceng' => 'Ceng',
            'lockuser' => 'Lockuser',
            'pic' => '邮政编码',
            'bd' => 'Bd',
            'baodan' => '代理商',
            'ppath' => 'Ppath',
            'rpath' => 'Rpath',
            'pay_points' => 'Pay Points',
            'pay_points_all' => 'Pay Points All',
            'sheng' => 'Sheng',
            'shi' => 'Shi',
            'xian' => 'Xian',
            'aixinjijin' => 'Aixinjijin',
            'yuanshigu' => 'Yuanshigu',
            'ysg_count' => 'Ysg Count',
            'dl_money' => 'Dl Money',
            'dl_money_count' => 'Dl Money Count',
            'yyaxjj' => 'Yyaxjj',
            'dllevel' => 'Dllevel',
            'ffyuanshigu' => 'Ffyuanshigu',
            'isjiangli' => 'Isjiangli',
            'commission' => 'Commission',
            'principal' => 'Principal',
            'dlno' => 'Dlno',
            'newyouxiaoyeji1' => 'Newyouxiaoyeji1',
            'newyouxiaoyeji2' => 'Newyouxiaoyeji2',
            'login_count' => 'login_count',
            'login_time' => 'login_time',
            'login_ip' => 'login_ip',
            'bdr' => 'bdr',
            'fuwuuser' => '服务中心',
        ];
    }
    
    public function addUsers($uname,$uinfo,$area,$p = 0){
	    $this->loginname = trim($uname);
	    $this->rid = $uinfo['loginname'];
	    $this->pid = $uinfo['loginname'];
	    $this->pwd1 = $uinfo['pwd1'];
	    $this->pwd2 = $uinfo['pwd2'];
	    $this->area = $area;
	    $this->rpath = $uinfo['rpath'];
	    $this->ppath = $uinfo['ppath'].",".$uinfo['id'];
	    $this->dai = $uinfo['dai']+1;
	    $this->ceng = $uinfo['ceng']+1;
	    $this->standardlevel = 3;
	    $this->addtime = date("Y-m-d",time());
	    $this->jihuotime = date("Y-m-d H:i:s",time());
	    $this->pay_points_all = $p;
	    if(!empty($uinfo['baodan']))
	        $this->baodan = $uinfo['baodan'];
	    if(!empty($uinfo['bdr']))
		    $this->bdr = $uinfo['bdr'];
	
	    if(!$this->save()){
		    $err = $this->getErrors();
		    list($first_key, $first) = (reset($err) ? each($err) : each($err));
		    return $first['0'];
	    }
	    $this->uids = Yii::$app->db->getLastInsertID();
	    $userall = $this->find()->where(['in','id',explode(',',$uinfo['ppath'].",".$uinfo['id'])])->asArray()->select(['id','area'])->orderBy('id desc')->all();
	    $left = $right = [];
	    $str  = $area;
	    foreach ($userall as $key => $val){
		    if($str == 1){
			    $left[] = $val['id'];
		    }else if($str == 2){
			    $right[] = $val['id'];
		    }
		    $str = $val['area'];
	    }
	    $rets  = Yii::$app->db->createCommand('UPDATE users SET num1=num1+1 WHERE id in('.(implode(',', $left)).')')->execute();
	    if(!$rets){
		    $err = $this->getErrors();
		    list($first_key, $first) = (reset($err) ? each($err) : each($err));
		    return $first['0'];
	    }
	    $rets  = Yii::$app->db->createCommand('UPDATE users SET num2=num2+1 WHERE id in('.(implode(',', $right)).')')->execute();
	    if(!$rets){
		    $err = $this->getErrors();
		    list($first_key, $first) = (reset($err) ? each($err) : each($err));
		    return $first['0'];
	    }
	   /* $rets  = Yii::$app->db->createCommand('UPDATE zm_position SET r_vip_num=r_vip_num+1 WHERE uname = \''.$uinfo['rid'].'\'')->execute();
	    if(!$rets){
		    $err = $this->getErrors();
		    list($first_key, $first) = (reset($err) ? each($err) : each($err));
		    return $first['0'];
	    }*/
		return true;
	   
	    
    }
    
}
