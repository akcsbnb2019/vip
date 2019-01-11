<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "stocks".
 *
 * @property integer $id
 * @property string $username
 * @property integer $stocks
 * @property string $adddate
 * @property string $addtime
 * @property string $yyje
 * @property string $bfje
 */
class Stocks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stocks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stocks'], 'integer'],
            [['adddate', 'addtime'], 'safe'],
            [['yyje', 'bfje'], 'number'],
            [['username'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'stocks' => 'Stocks',
            'adddate' => 'Adddate',
            'addtime' => 'Addtime',
            'yyje' => 'Yyje',
            'bfje' => 'Bfje',
        ];
    }
}
