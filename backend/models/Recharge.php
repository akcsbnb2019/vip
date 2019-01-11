<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "recharge".
 *
 * @property string $id
 * @property string $user
 * @property string $money
 * @property string $memo
 * @property integer $incomeId
 * @property string $createdTime
 */
class Recharge extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recharge';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user', 'money'], 'required'],
            [['money'], 'number'],
            [['incomeId'], 'integer'],
            [['createdTime'], 'safe'],
            [['user', 'memo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'User',
            'money' => 'Money',
            'memo' => 'Memo',
            'incomeId' => 'Income ID',
            'createdTime' => 'Created Time',
        ];
    }
}
