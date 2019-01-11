<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "ecs_goods".
 *
 * @property string $goods_id
 * @property integer $cat_id
 * @property string $goods_sn
 * @property string $goods_name
 * @property string $goods_name_style
 * @property string $click_count
 * @property integer $brand_id
 * @property string $provider_name
 * @property integer $goods_number
 * @property string $goods_weight
 * @property string $market_price
 * @property string $shop_price
 * @property string $promote_price
 * @property string $promote_start_date
 * @property string $promote_end_date
 * @property integer $warn_number
 * @property string $keywords
 * @property string $goods_brief
 * @property string $goods_desc
 * @property string $goods_thumb
 * @property string $goods_img
 * @property string $original_img
 * @property integer $is_real
 * @property string $extension_code
 * @property integer $is_on_sale
 * @property integer $auto_delivery
 * @property integer $is_alone_sale
 * @property integer $is_shipping
 * @property string $integral
 * @property string $add_time
 * @property integer $sort_order
 * @property integer $is_delete
 * @property integer $is_best
 * @property integer $is_new
 * @property integer $is_hot
 * @property integer $is_promote
 * @property integer $is_one
 * @property integer $is_how
 * @property integer $bonus_type_id
 * @property string $last_update
 * @property integer $goods_type
 * @property string $seller_note
 * @property integer $give_integral
 * @property integer $rank_integral
 * @property integer $suppliers_id
 * @property integer $is_check
 * @property string $xsc
 * @property integer $is_pass
 * @property string $reason
 * @property integer $shipping_id
 * @property integer $is_vip1
 * @property integer $is_vip2
 * @property integer $is_vip3
 * @property integer $is_putong
 * @property string $goods_yongjin
 * @property integer $is_agent
 * @property integer $min_buy_number
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ecs_goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_id', 'click_count', 'brand_id', 'goods_number', 'promote_start_date', 'promote_end_date', 'warn_number', 'is_real', 'is_on_sale', 'auto_delivery', 'is_alone_sale', 'is_shipping', 'integral', 'add_time', 'sort_order', 'is_delete', 'is_best', 'is_new', 'is_hot', 'is_promote', 'is_one', 'is_how', 'bonus_type_id', 'last_update', 'goods_type', 'give_integral', 'rank_integral', 'suppliers_id', 'is_check', 'is_pass', 'shipping_id', 'is_vip1', 'is_vip2', 'is_vip3', 'is_putong', 'is_agent', 'min_buy_number'], 'integer'],
            [['goods_weight', 'market_price', 'shop_price', 'promote_price', 'goods_yongjin'], 'number'],
            [['goods_desc', 'is_pass', 'reason'], 'required'],
            [['goods_desc'], 'string'],
            [['goods_sn', 'goods_name_style'], 'string', 'max' => 60],
            [['goods_name'], 'string', 'max' => 120],
            [['provider_name'], 'string', 'max' => 100],
            [['keywords', 'goods_brief', 'goods_thumb', 'goods_img', 'original_img', 'seller_note'], 'string', 'max' => 255],
            [['extension_code'], 'string', 'max' => 30],
            [['xsc'], 'string', 'max' => 300],
            [['reason'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'goods_id' => 'Goods ID',
            'cat_id' => 'Cat ID',
            'goods_sn' => 'Goods Sn',
            'goods_name' => 'Goods Name',
            'goods_name_style' => 'Goods Name Style',
            'click_count' => 'Click Count',
            'brand_id' => 'Brand ID',
            'provider_name' => 'Provider Name',
            'goods_number' => 'Goods Number',
            'goods_weight' => 'Goods Weight',
            'market_price' => 'Market Price',
            'shop_price' => 'Shop Price',
            'promote_price' => 'Promote Price',
            'promote_start_date' => 'Promote Start Date',
            'promote_end_date' => 'Promote End Date',
            'warn_number' => 'Warn Number',
            'keywords' => 'Keywords',
            'goods_brief' => 'Goods Brief',
            'goods_desc' => 'Goods Desc',
            'goods_thumb' => 'Goods Thumb',
            'goods_img' => 'Goods Img',
            'original_img' => 'Original Img',
            'is_real' => 'Is Real',
            'extension_code' => 'Extension Code',
            'is_on_sale' => 'Is On Sale',
            'auto_delivery' => 'Auto Delivery',
            'is_alone_sale' => 'Is Alone Sale',
            'is_shipping' => 'Is Shipping',
            'integral' => 'Integral',
            'add_time' => 'Add Time',
            'sort_order' => 'Sort Order',
            'is_delete' => 'Is Delete',
            'is_best' => 'Is Best',
            'is_new' => 'Is New',
            'is_hot' => 'Is Hot',
            'is_promote' => 'Is Promote',
            'is_one' => 'Is One',
            'is_how' => 'Is How',
            'bonus_type_id' => 'Bonus Type ID',
            'last_update' => 'Last Update',
            'goods_type' => 'Goods Type',
            'seller_note' => 'Seller Note',
            'give_integral' => 'Give Integral',
            'rank_integral' => 'Rank Integral',
            'suppliers_id' => 'Suppliers ID',
            'is_check' => 'Is Check',
            'xsc' => 'Xsc',
            'is_pass' => 'Is Pass',
            'reason' => 'Reason',
            'shipping_id' => 'Shipping ID',
            'is_vip1' => 'Is Vip1',
            'is_vip2' => 'Is Vip2',
            'is_vip3' => 'Is Vip3',
            'is_putong' => 'Is Putong',
            'goods_yongjin' => 'Goods Yongjin',
            'is_agent' => 'Is Agent',
            'min_buy_number' => 'Min Buy Number',
        ];
    }
}
