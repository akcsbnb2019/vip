<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "mobile_sms".
 *
 * @property integer $id
 * @property string $phone
 * @property string $msg
 * @property string $date
 */
class MobileSms extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mobile_sms';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone', 'date'], 'required'],
            [['date'], 'safe'],
            [['phone'], 'string', 'max' => 64],
            [['msg'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone' => 'Phone',
            'msg' => 'Msg',
            'date' => 'Date',
        ];
    }

    function Post($curlPost, $url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
        $return_str = curl_exec($curl);
        curl_close($curl);
        return mb_convert_encoding($return_str, 'UTF-8');
    }

    function xml_to_array($xml)
    {
        $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
        if (preg_match_all($reg, $xml, $matches)) {
            $count = count($matches[0]);
            for ($i = 0; $i < $count; $i++) {
                $subxml = $matches[2][$i];
                $key = $matches[1][$i];
                if (preg_match($reg, $subxml)) {
                    $arr[$key] = $this->xml_to_array($subxml);
                } else {
                    $arr[$key] = $subxml;
                }
            }
        }
        return $arr;
    }

    function random($length = 6, $numeric = 0)
    {
        PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
        if ($numeric) {
            $hash = sprintf('%0' . $length . 'd', mt_rand(0, pow(10, $length) - 1));
        } else {
            $hash = '';
            $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcdefghjkmnpqrstuvwxyz';
            $max = strlen($chars) - 1;
            for ($i = 0; $i < $length; $i++) {
                $hash .= $chars[mt_rand(0, $max)];
            }
        }
        return $hash;
    }
    function AddCode($mobile='',$user='',$types = 0)
    {
        $target = "http://106.ihuyi.com/webservice/sms.php?method=Submit";
        if(!isset($mobile)){
            return ['status'=>2,'msg'=>'手机号及验证码错误!'];
        }
        $mobile_code = $this->random(4, 1);
        if (empty($mobile)) {
            return ['status'=>2,'msg'=>'手机号码不能为空!'];
        }
        if (!preg_match('/^\d{11}$/', $mobile)) {
            return ['status'=>2,'msg'=>'手机号码不正确!'];
        }
        if ($mobile == "18628693117") {
            return ['status'=>2,'msg'=>'此手机号已被列入黑名单!'];
        }
        if ($mobile <> $user['tel']) {
            return ['status'=>2,'msg'=>'手机号有误,请稍后重试!'];
        }
        $date = date("Y-m-d")." 00:00:00";
        $tmp = static::find()->where("phone=:phone",[':phone'=>$mobile])->andWhere(['types'=>$types])->andWhere(['>','date',$date])->count();
		$maxsum = [
			0=>['num'=>5,'msg'=>'安全码获取今日已达到限制'],
			1=>['num'=>70,'msg'=>'[转账]您的验证码获取今日已达到限制'],
			2=>['num'=>10,'msg'=>'[提现]您的验证码获取今日已达到限制'],
			3=>['num'=>5,'msg'=>'[注册]您的验证码获取今日已达到限制'],/*
			4=>['num'=>5,'msg'=>'[修改二级密码]您的验证码获取今日已达到限制'],*/
			8=>['num'=>10,'msg'=>'[查看股权]您的验证码获取今日已达到限制'],
		];
		
        if($tmp >= $maxsum[$types]['num']){
            return ['status'=>2,'msg'=>$maxsum[$types]['msg']];
        }
        
	    $sms_info = [
	    	0=>"您的安全码是：" . $mobile_code . "。请不要把安全码泄露给其他人。",
	    	1=>"您的账号：".$user['loginname']." 正在进行转账操作，安全码为：".$mobile_code."，为保障您的账户资金安全，手机安全码请勿外泄。",
	    	2=>"您的账号：".$user['loginname']." 正在进行提现到银行卡操作，安全码为：".$mobile_code."，为保障您的账户资金安全，手机安全码请勿外泄。",
	    	3=>"尊敬的 ".$user['truename']." 贵宾，您好！您的账号 ".$user['loginname']." 已注册成功，为方便给您提供更优质的服务，请登陆会员系统完善个人信息。德行天下，造福万家，大爱的领航伴您开启美好的购物体验之旅，商城网址: http://www.yhr001.com 如有任何疑问，欢迎拨打服务电话: 4006216066 咨询，非常感谢您的关注与支持！恭祝:如意吉祥，幸福安康！",
//	    	4=>"您的账号：".$user['loginname']." 正在进行修改二级密码操作，安全码为：".$mobile_code."，为保障您的账户资金安全，手机安全码请勿外泄。",
//	    	5=>"您的账号：".$user['loginname']." 正在进行修改资料操作，安全码为：".$mobile_code."，为保障您的账户资金安全，手机安全码请勿外泄。",
	    	8=>"您的账号：".$user['loginname']." 正在进行查看股权证书操作，安全码为：".$mobile_code."，为保障您的账户安全，手机安全码请勿外泄。",
	    ];
	
	    $this->phone = $mobile;
        $this->date = date("Y-m-d H:i:s",time());
	    $this->types = $types;
	    if($this->save()){
            $post_data = "account=cf_dongsheng&password=123456&mobile=" . $mobile . "&content=" . rawurlencode($sms_info[$types]);
            $gets = $this->xml_to_array($this->Post($post_data, $target));
            if ($gets['SubmitResult']['code'] == 2) {
                Yii::$app->session->set('mobile',$mobile);
                Yii::$app->session->set('mobile_code',$mobile_code);
            }
            return ['status'=>1,'msg'=>$gets['SubmitResult']['msg']];

        }else{
            return false;
        }
    }
    
}
