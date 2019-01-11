<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "users".
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
 */
class Users extends \yii\db\ActiveRecord
{
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
        return [
            [['rid','pwd2'], 'string', 'max' => 50,'min' => 4],
            /*[['pid', 'rid', 'loginname', 'pwd1', 'pwd2', 'pwd3', 'zhengshuid', 'truename', 'address', 'identityid', 'bank', 'bankno', 'bankname', 'bankaddress', 'tel', 'qq', 'addtime', 'adddate', 'jihuotime', 'pic', 'ppath', 'rpath', 'isjiangli'], 'required'],
            [['standardlevel', 'ystandardlevel', 'newstandardlevel', 'states', 'area', 'num1', 'num2', 'dai', 'ceng', 'lockuser', 'bd', 'sheng', 'shi', 'xian', 'yuanshigu', 'ysg_count', 'dllevel', 'ffyuanshigu', 'isjiangli'], 'integer'],
            [['addtime', 'adddate', 'jihuotime'], 'safe'],
            [['amount', 'inputamount', 'yeji1', 'yeji2', 'allyeji1', 'allyeji2', 'allyouxiaoyeji1', 'allyouxiaoyeji2', 'pay_points', 'pay_points_all', 'aixinjijin', 'dl_money', 'dl_money_count', 'yyaxjj', 'commission', 'principal'], 'number'],
            [['ppath', 'rpath'], 'string'],
            [['pid', 'rid', 'loginname', 'pwd1', 'pwd2', 'pwd3', 'zhengshuid', 'truename', 'address', 'identityid', 'bank', 'bankno', 'bankname', 'bankaddress', 'tel', 'qq', 'pic', 'baodan'], 'string', 'max' => 50],
            [['dlno'], 'string', 'max' => 64],
            [['loginname'], 'unique'],
            [['pid', 'area'], 'unique', 'targetAttribute' => ['pid', 'area'], 'message' => 'The combination of Pid and Area has already been taken.'],*/
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => 'Pid',
            'rid' => '推荐人',
            'loginname' => '用户名',
            'standardlevel' => 'Standardlevel',
            'ystandardlevel' => 'Ystandardlevel',
            'newstandardlevel' => 'Newstandardlevel',
            'pwd1' => 'Pwd1',
            'pwd2' => 'Pwd2',
            'pwd3' => 'Pwd3',
            'zhengshuid' => 'Zhengshuid',
            'states' => 'States',
            'truename' => 'Truename',
            'address' => 'Address',
            'identityid' => 'Identityid',
            'bank' => 'Bank',
            'bankno' => 'Bankno',
            'bankname' => 'Bankname',
            'bankaddress' => 'Bankaddress',
            'tel' => 'Tel',
            'qq' => 'Qq',
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
            'pic' => 'Pic',
            'bd' => 'Bd',
            'baodan' => 'Baodan',
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
        ];
    }
}
