<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property string $id
 * @property integer $senduid
 * @property integer $recuid
 * @property string $parent_id
 * @property string $title
 * @property string $content
 * @property integer $addtime
 * @property integer $states
 * @property string $flag
 */
class Messagem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zm_chat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['recuid', 'parent_id','content','addtime'], 'required'],
            [['senduid', 'recuid', 'parent_id', 'addtime', 'states', 'flag'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'senduid' => '留言人',
            'recuid' => '回复人',
            'parent_id' => 'Parent ID',
            'title' => '标题',
            'content' => '内容',
            'addtime' => '添加时间',
            'states' => 'States',
            'flag' => 'Flag',
        ];
    }
}
