<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "zm_vip_menu".
 *
 * @property string $id
 * @property string $name
 * @property string $desc
 * @property string $cat_id
 * @property string $group_name
 * @property integer $sort
 * @property integer $status
 * @property string $add_time
 * @property integer $type
 * @property integer $subset
 */
class VipMenu extends \yii\db\ActiveRecord
{
    public $kong = true;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zm_vip_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $r = [
            [['name', 'url_key', 'icon', 'group_name'], 'trim'],
            [['name','url_key'], 'required'],
            [['cat_id', 'sort', 'status', 'add_time', 'type', 'subset'], 'integer'],
            [['status','subset'], 'in', 'range' => [-1,0,1,2,3]],
            ['sort', 'compare', 'compareValue' => 0, 'operator' => '>='],
            [['sort','type'], 'compare', 'compareValue' => 99, 'operator' => '<='],
            ['cat_id', 'compare', 'compareValue' => 500, 'operator' => '<='],
            [['name', 'group_name'], 'string', 'max' => 8],
            [['name', 'group_name'], 'match', 'pattern'=>'/^[(\x{4E00}-\x{9FA5})a-zA-Z]+[(\x{4E00}-\x{9FA5})a-zA-Z_\d]*$/u', 'message'=>'请输入中文'],
            ['desc', 'match', 'pattern'=>'/^[(\x{4E00}-\x{9FA5})a-zA-Z]+[(\x{4E00}-\x{9FA5})a-zA-Z_\d]*$/u', 'message'=>'请输入中文'],
            [['url_key', 'icon'], 'string', 'max' => 50],
            [['url_key', 'icon'], 'match', 'pattern'=>'/^[A-Za-z0-9_-]+$/', 'message'=>'请输入字母和下划线'],
            ['desc', 'string', 'max' => 255],
            ['add_time', 'default', 'value' => time()],
        ];
        
        if($this->kong){
            $r['nameun'] = ['name', 'unique'];
        }
        return $r;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'url_key' => 'Url名',
            'desc' => '简介',
            'cat_id' => '上级菜单',
            'group_name' => '分组',
            'sort' => '排序',
            'status' => '状态',
            'add_time' => '添加时间',
            'type' => '类型',
            'subset' => '子集',
            'icon' => '图标名',
        ];
        
        /*
         * 
            'desc' => '简介',*/
    }
}
