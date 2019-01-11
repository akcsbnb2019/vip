<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "config".
 *
 * @property integer $id
 * @property integer $t1
 * @property string $t2
 */
class Config extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['t1'], 'integer'],
            [['t2'], 'required'],
            [['t2'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            't1' => 'T1',
            't2' => 'T2',
        ];
    }
}
