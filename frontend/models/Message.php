<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property string $id
 * @property string $parent_id
 * @property string $title
 * @property string $content
 * @property string $addtime
 * @property string $adddate
 * @property string $states
 * @property string $flag
 * @property string $userid
 */
class Message extends \yii\db\ActiveRecord
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
            [['parent_id', 'states', 'flag'], 'integer'],
            [['content'], 'string'],
            [['title','content'],'match', 'pattern'=>"/^[0-9A-Za-z_\\x{4e00}-\\x{9fa5}. ，。（）“”？]+$/u", 'message'=>'请输入文字及中文标点符号，”逗号“。”句号“”引号！'],
            [['addtime', 'adddate'], 'safe'],
            [['title', 'content'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'title' => 'Title',
            'content' => 'Content',
            'addtime' => 'Addtime',
            'adddate' => 'Adddate',
            'states' => 'States',
            'flag' => 'Flag',
            'userid' => 'Userid',
        ];
    }
}
