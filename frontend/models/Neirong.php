<?php

namespace frontend\models;

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
class Neirong extends \yii\db\ActiveRecord
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
            [['types', 'pic', 'title', 'content', 'UpdateTime', 'BegindateTime', 'EnddateTime'], 'required'],
            [['types'], 'integer'],
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
            'ArticleID' => 'Article ID',
            'types' => 'Types',
            'pic' => 'Pic',
            'title' => 'Title',
            'content' => 'Content',
            'UpdateTime' => 'Update Time',
            'BegindateTime' => 'Begindate Time',
            'EnddateTime' => 'Enddate Time',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getOne($id){
        return self::findOne(['ArticleID' => intval($id)]);
    }
}
