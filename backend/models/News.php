<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "neirong".
 *
 * @property integer $ArticleID
 * @property integer $types
 * @property string $pic
 * @property string $title
 * @property string $content
 * @property string $UpdateTime
 * @property string $BegindateTime
 * @property string $EnddateTime
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'neirong';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['types', 'pic', 'title', 'content', 'UpdateTime', 'BegindateTime', 'EnddateTime', 'status'], 'required'],
            [['types', 'status'], 'integer'],
            [['content'], 'string'],
            [['UpdateTime', 'BegindateTime', 'EnddateTime'], 'safe'],
            [['pic', 'title'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ArticleID' => 'ID',
            'types' => '类型',
            'pic' => '图片',
            'title' => '标题',
            'content' => '详情',
            'UpdateTime' => '录入时间',
            'BegindateTime' => '开始时间',
            'EnddateTime' => '结束时间',
            'status' => '状态',
        ];
    }
}
