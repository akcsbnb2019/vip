<?php

namespace frontend\models;

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
    public $title1;
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
            [[ 'title', 'content'], 'required'],
            //[['senduid', 'recuid', 'parent_id', 'addtime', 'states', 'flag'], 'integer'],
            [['content','title'], 'string'],
	        [['title','content'],'match', 'pattern'=>"/^[0-9A-Za-z_\\x{4e00}-\\x{9fa5}. ，。（）“”？]+$/u", 'message'=>'请输入文字及中文标点符号，”逗号“。”句号“”引号！'],
	
	        //['title','match', 'pattern'=>"/^[0-9A-Za-z_\x{4e00}-\x{9fa5}.]+$/u", 'message'=>'请输入中文'],
            //['content','match', 'pattern'=>"/^[0-9A-Za-z_\x{4e00}-\x{9fa5}.]+$/u", 'message'=>'请不要使用特殊符号'],
            ['title', 'string', 'max' => 20],
            ['content', 'string', 'max' => 200],
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
