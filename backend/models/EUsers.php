<?php

namespace backend\models;

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
	public $jifen;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jifen'], 'number'],
            [['user_name'], 'required'],
            [[ 'user_name'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_name' => '帐号',
            'jifen' => '积分',
        ];
    }
}
