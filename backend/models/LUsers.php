<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property string $id
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
 * @property string $djamount
 * @property integer $area
 * @property string $yeji1
 * @property string $yeji2
 * @property string $num1
 * @property string $num2
 * @property string $allyeji1
 * @property string $allyeji2
 * @property string $allyouxiaoyeji1
 * @property string $allyouxiaoyeji2
 * @property string $dai
 * @property string $ceng
 * @property integer $lockuser
 * @property string $pic
 * @property integer $bd
 * @property string $baodan
 * @property string $bdl
 * @property string $bdr
 * @property string $ppath
 * @property string $rpath
 * @property string $pay_points
 * @property string $pay_points_all
 * @property string $sheng
 * @property string $shi
 * @property string $xian
 * @property string $aixinjijin
 * @property string $yuanshigu
 * @property integer $ysg_count
 * @property string $dl_money
 * @property string $dl_money_count
 * @property string $yyaxjj
 * @property integer $dllevel
 * @property string $ffyuanshigu
 * @property integer $isjiangli
 * @property string $commission
 * @property string $principal
 * @property string $dlno
 * @property string $newyouxiaoyeji1
 * @property string $newyouxiaoyeji2
 * @property string $login_time
 * @property string $login_count
 * @property string $login_ip
 * @property string $allamount
 * @property integer $position
 * @property integer $status
 * @property string $cx_vipyeji1
 * @property string $cx_vipyeji2
 * @property string $lallyeji
 * @property string $rallyeji
 * @property string $voucher
 */
class LUsers extends \yii\db\ActiveRecord
{
	public $level;
	public $loginnames;
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
            [['level', 'loginnames'], 'required'],
            [['loginnames'], 'string', 'max' => 9999],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'loginnames' => '用户名',
            'level' => '级别',
        ];
    }
}
