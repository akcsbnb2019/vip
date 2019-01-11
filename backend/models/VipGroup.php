<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "zm_vip_group".
 *
 * @property string $id
 * @property string $name
 * @property string $desc
 * @property string $auth
 * @property integer $sort
 * @property integer $status
 * @property string $add_time
 * @property integer $type
 */
class VipGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zm_vip_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['auth'], 'string'],
            [['sort', 'status', 'add_time', 'type'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['desc'], 'string', 'max' => 255],
            ['add_time', 'default', 'value' => time()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'desc' => '简介',
            'auth' => '权限表',
            'sort' => '排序',
            'status' => '状态',
            'add_time' => '添加时间',
            'type' => '类型',
        ];
    }
}
