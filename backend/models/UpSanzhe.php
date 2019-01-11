<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "up_sanzhe".
 *
 * @property string $id
 * @property string $user_name
 * @property string $pay_points
 * @property string $rank_points
 * @property string $user_coupon
 * @property string $first_coupon
 * @property string $coupon_rank_points
 * @property string $up_pay_points
 * @property string $up_rank_points
 * @property string $up_user_coupon
 * @property string $up_first_coupon
 * @property string $up_coupon_rank_points
 * @property string $addtime
 * @property string $admin_name
 */
class UpSanzhe extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'up_sanzhe';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pay_points', 'rank_points', 'user_coupon', 'first_coupon', 'coupon_rank_points', 'up_pay_points', 'up_rank_points', 'up_user_coupon', 'up_first_coupon', 'up_coupon_rank_points'], 'number'],
            [['addtime'], 'safe'],
            [['user_name', 'admin_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_name' => 'User Name',
            'pay_points' => 'Pay Points',
            'rank_points' => 'Rank Points',
            'user_coupon' => 'User Coupon',
            'first_coupon' => 'First Coupon',
            'coupon_rank_points' => 'Coupon Rank Points',
            'up_pay_points' => 'Up Pay Points',
            'up_rank_points' => 'Up Rank Points',
            'up_user_coupon' => 'Up User Coupon',
            'up_first_coupon' => 'Up First Coupon',
            'up_coupon_rank_points' => 'Up Coupon Rank Points',
            'addtime' => 'Addtime',
            'admin_name' => 'Admin Name',
        ];
    }
}
