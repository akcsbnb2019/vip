<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "ecs_users".
 *
 * @property string $user_id
 * @property string $email
 * @property string $user_name
 * @property string $password
 * @property string $question
 * @property string $answer
 * @property integer $sex
 * @property string $birthday
 * @property string $user_money
 * @property string $frozen_money
 * @property string $pay_points
 * @property string $rank_points
 * @property string $address_id
 * @property string $reg_time
 * @property string $last_login
 * @property string $last_time
 * @property string $last_ip
 * @property integer $visit_count
 * @property integer $user_rank
 * @property integer $is_special
 * @property string $salt
 * @property integer $parent_id
 * @property integer $flag
 * @property string $alias
 * @property string $msn
 * @property string $qq
 * @property string $avatar
 * @property string $office_phone
 * @property string $home_phone
 * @property string $mobile_phone
 * @property integer $is_validated
 * @property string $credit_line
 * @property string $passwd_question
 * @property string $passwd_answer
 * @property string $user_coupon
 * @property integer $coupon_status
 * @property string $first_coupon
 * @property string $coupon_rank_points
 * @property string $agent_amount
 * @property integer $ischongzhi
 */
class EUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ecs_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sex', 'address_id', 'reg_time', 'last_login', 'visit_count', 'user_rank', 'is_special', 'parent_id', 'flag', 'is_validated', 'coupon_status', 'ischongzhi'], 'integer'],
            [['birthday', 'last_time'], 'safe'],
            [['user_money', 'frozen_money', 'pay_points', 'rank_points', 'credit_line', 'user_coupon', 'first_coupon', 'coupon_rank_points', 'agent_amount'], 'number'],
            [['user_name', 'password', 'mobile_phone'], 'required'],
            [['email', 'user_name', 'alias', 'msn'], 'string', 'max' => 60],
            [['password'], 'string', 'max' => 32],
            [['question', 'answer', 'passwd_answer'], 'string', 'max' => 255],
            [['last_ip'], 'string', 'max' => 15],
            [['salt'], 'string', 'max' => 10],
            [['qq', 'office_phone', 'home_phone', 'mobile_phone'], 'string', 'max' => 20],
            [['avatar'], 'string', 'max' => 200],
            [['passwd_question'], 'string', 'max' => 50],
            [['user_name'], 'unique'],
            [['question','answer','avatar','salt','alias','msn','qq','office_phone','home_phone','last_ip'], 'default', 'value' => '0'],
            [['user_coupon','first_coupon','coupon_rank_points','agent_amount'], 'default', 'value' => '0.00'],
            ['birthday', 'default', 'value' => '0000-00-00'],
            ['last_time', 'default', 'value' => '0000-00-00 00:00:00'],
            ['reg_time', 'default', 'value' => time()],
            [['sex','user_money','frozen_money','pay_points','rank_points','address_id','last_login','visit_count','user_rank','is_special','parent_id','flag','is_validated','credit_line','ischongzhi'], 'default', 'value' => 0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'email' => 'Email',
            'user_name' => 'User Name',
            'password' => 'Password',
            'question' => 'Question',
            'answer' => 'Answer',
            'sex' => 'Sex',
            'birthday' => 'Birthday',
            'user_money' => 'User Money',
            'frozen_money' => 'Frozen Money',
            'pay_points' => 'Pay Points',
            'rank_points' => 'Rank Points',
            'address_id' => 'Address ID',
            'reg_time' => 'Reg Time',
            'last_login' => 'Last Login',
            'last_time' => 'Last Time',
            'last_ip' => 'Last Ip',
            'visit_count' => 'Visit Count',
            'user_rank' => 'User Rank',
            'is_special' => 'Is Special',
            'salt' => 'Salt',
            'parent_id' => 'Parent ID',
            'flag' => 'Flag',
            'alias' => 'Alias',
            'msn' => 'Msn',
            'qq' => 'Qq',
            'avatar' => 'Avatar',
            'office_phone' => 'Office Phone',
            'home_phone' => 'Home Phone',
            'mobile_phone' => 'Mobile Phone',
            'is_validated' => 'Is Validated',
            'credit_line' => 'Credit Line',
            'passwd_question' => 'Passwd Question',
            'passwd_answer' => 'Passwd Answer',
            'user_coupon' => 'User Coupon',
            'coupon_status' => 'Coupon Status',
            'first_coupon' => 'First Coupon',
            'coupon_rank_points' => 'Coupon Rank Points',
            'agent_amount' => 'Agent Amount',
            'ischongzhi' => 'Ischongzhi',
        ];
    }
    
    /**
     * 注册商城用户
     * @param unknown $name
     * @param unknown $pwd
     * @param unknown $tel
     * @return boolean
     */
    public function addEUsers($name,$pwd,$tel,$pay_points = 0,$alias ='0'){
        $this->user_name    = $name;
        $this->password     = $pwd;
        $this->mobile_phone = $tel;
        $this->pay_points = $pay_points;
        $this->rank_points = $pay_points;
        $this->email        = '';
        $this->alias        = $alias;

        if($this->save()){
            return true;
        }else{
            return false;
        }
    }
}
