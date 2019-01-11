<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "ecs_order_info".
 *
 * @property string $order_id
 * @property string $device
 * @property string $order_sn
 * @property string $user_id
 * @property integer $order_status
 * @property integer $shipping_status
 * @property integer $pay_status
 * @property string $consignee
 * @property integer $country
 * @property integer $province
 * @property integer $city
 * @property integer $district
 * @property string $address
 * @property string $zipcode
 * @property string $tel
 * @property string $mobile
 * @property string $email
 * @property string $best_time
 * @property string $sign_building
 * @property string $postscript
 * @property integer $shipping_id
 * @property string $shipping_name
 * @property integer $pay_id
 * @property string $pay_name
 * @property string $how_oos
 * @property string $how_surplus
 * @property string $pack_name
 * @property string $card_name
 * @property string $card_message
 * @property string $inv_payee
 * @property string $inv_content
 * @property string $goods_amount
 * @property string $shipping_fee
 * @property string $insure_fee
 * @property string $pay_fee
 * @property string $pack_fee
 * @property string $card_fee
 * @property string $money_paid
 * @property string $surplus
 * @property string $integral
 * @property string $integral_money
 * @property string $bonus
 * @property string $order_amount
 * @property integer $from_ad
 * @property string $referer
 * @property string $add_time
 * @property string $confirm_time
 * @property string $pay_time
 * @property string $shipping_time
 * @property integer $pack_id
 * @property integer $card_id
 * @property string $bonus_id
 * @property string $invoice_no
 * @property string $extension_code
 * @property string $extension_id
 * @property string $to_buyer
 * @property string $pay_note
 * @property integer $agency_id
 * @property string $inv_type
 * @property string $tax
 * @property integer $is_separate
 * @property string $parent_id
 * @property string $discount
 * @property string $custom_points
 * @property string $rank_points
 * @property string $coupon
 * @property integer $order_type
 * @property string $shop_id
 * @property string $buyin_money
 * @property string $buyout_money
 * @property integer $is_tihuo
 * @property string $tihuo_desc
 * @property integer $is_shenqing
 * @property string $shenqing_time
 * @property string $is_none
 * @property string $commission
 * @property string $commission_id
 * @property string $principal
 */
class OrderInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $up_standardlevel = 0;
    public $luname;
    public $runame;
    public $goods_id;

    public $isleft;
    public static function tableName()
    {
        return 'ecs_order_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'order_status', 'shipping_status', 'pay_status', 'country', 'province', 'city', 'district', 'shipping_id', 'pay_id', 'integral', 'from_ad', 'add_time', 'confirm_time', 'pay_time', 'shipping_time', 'pack_id', 'card_id', 'bonus_id', 'extension_id', 'agency_id', 'is_separate', 'parent_id', 'order_type', 'shop_id', 'is_tihuo', 'is_shenqing', 'shenqing_time', 'is_none', 'commission_id'], 'integer'],
            [['goods_amount', 'shipping_fee', 'insure_fee', 'pay_fee', 'pack_fee', 'card_fee', 'money_paid', 'surplus', 'integral_money', 'bonus', 'order_amount', 'tax', 'discount', 'custom_points', 'rank_points', 'coupon', 'buyin_money', 'buyout_money', 'commission', 'principal'], 'number'],
            [['agency_id', 'inv_type', 'tax', 'discount', 'buyin_money', 'buyout_money', 'tihuo_desc'], 'required'],
            [['device'], 'string', 'max' => 64],
            [['order_sn'], 'string', 'max' => 20],
            [['consignee', 'zipcode', 'tel', 'mobile', 'email', 'inv_type'], 'string', 'max' => 60],
            [['address', 'postscript', 'card_message', 'referer', 'invoice_no', 'to_buyer', 'pay_note', 'tihuo_desc'], 'string', 'max' => 255],
            [['best_time', 'sign_building', 'shipping_name', 'pay_name', 'how_oos', 'how_surplus', 'pack_name', 'card_name', 'inv_payee', 'inv_content'], 'string', 'max' => 120],
            [['extension_code'], 'string', 'max' => 30],
            [['order_sn'], 'unique'],

            [['consignee', 'district', 'city','province','address','zipcode','tel','luname','runame'], 'required'],
//            ['tel','match', 'pattern'=>"/^1[3,4,5,7,8,9]{1}[\d]{9}$/u", 'message'=> '{attribute}格式错误，请重新输入！'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'device' => 'Device',
            'order_sn' => 'Order Sn',
            'user_id' => 'User ID',
            'order_status' => 'Order Status',
            'shipping_status' => 'Shipping Status',
            'pay_status' => 'Pay Status',
            'consignee' => '收货人姓名',
            'country' => 'Country',
            'province' => 'Province',
            'city' => 'City',
            'district' => '地区',
            'address' => '详细地址',
            'zipcode' => '邮政编码',
            'tel' => '手机号',
            'mobile' => 'Mobile',
            'email' => 'Email',
            'best_time' => 'Best Time',
            'sign_building' => 'Sign Building',
            'postscript' => 'Postscript',
            'shipping_id' => 'Shipping ID',
            'shipping_name' => 'Shipping Name',
            'pay_id' => 'Pay ID',
            'pay_name' => 'Pay Name',
            'how_oos' => 'How Oos',
            'how_surplus' => 'How Surplus',
            'pack_name' => 'Pack Name',
            'card_name' => 'Card Name',
            'card_message' => 'Card Message',
            'inv_payee' => 'Inv Payee',
            'inv_content' => 'Inv Content',
            'goods_amount' => 'Goods Amount',
            'shipping_fee' => 'Shipping Fee',
            'insure_fee' => 'Insure Fee',
            'pay_fee' => 'Pay Fee',
            'pack_fee' => 'Pack Fee',
            'card_fee' => 'Card Fee',
            'money_paid' => 'Money Paid',
            'surplus' => 'Surplus',
            'integral' => 'Integral',
            'integral_money' => 'Integral Money',
            'bonus' => 'Bonus',
            'order_amount' => 'Order Amount',
            'from_ad' => 'From Ad',
            'referer' => 'Referer',
            'add_time' => 'Add Time',
            'confirm_time' => 'Confirm Time',
            'pay_time' => 'Pay Time',
            'shipping_time' => 'Shipping Time',
            'pack_id' => 'Pack ID',
            'card_id' => 'Card ID',
            'bonus_id' => 'Bonus ID',
            'invoice_no' => 'Invoice No',
            'extension_code' => 'Extension Code',
            'extension_id' => 'Extension ID',
            'to_buyer' => 'To Buyer',
            'pay_note' => 'Pay Note',
            'agency_id' => 'Agency ID',
            'inv_type' => 'Inv Type',
            'tax' => 'Tax',
            'is_separate' => 'Is Separate',
            'parent_id' => 'Parent ID',
            'discount' => 'Discount',
            'custom_points' => 'Custom Points',
            'rank_points' => 'Rank Points',
            'coupon' => 'Coupon',
            'order_type' => 'Order Type',
            'shop_id' => 'Shop ID',
            'buyin_money' => 'Buyin Money',
            'buyout_money' => 'Buyout Money',
            'is_tihuo' => 'Is Tihuo',
            'tihuo_desc' => 'Tihuo Desc',
            'is_shenqing' => 'Is Shenqing',
            'shenqing_time' => 'Shenqing Time',
            'is_none' => 'Is None',
            'commission' => 'Commission',
            'commission_id' => 'Commission ID',
            'principal' => 'Principal',
            'luname' =>'左区用户',
            'runame' =>'右区用户',
        ];
    }
}
