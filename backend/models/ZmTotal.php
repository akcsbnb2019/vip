<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "zm_total".
 *
 * @property string $id
 * @property string $userid
 * @property string $bonus
 * @property string $fuxiao
 * @property string $balance
 * @property string $tdgjj
 * @property string $position
 * @property string $declaration
 * @property string $addtime
 * @property integer $scount
 */
class ZmTotal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zm_total';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'addtime', 'scount'], 'integer'],
            [['bonus', 'fuxiao', 'balance', 'tdgjj', 'position', 'declaration'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => 'Userid',
            'bonus' => 'Bonus',
            'fuxiao' => 'Fuxiao',
            'balance' => 'Balance',
            'tdgjj' => 'Tdgjj',
            'position' => 'Position',
            'declaration' => 'Declaration',
            'addtime' => 'Addtime',
            'scount' => 'Scount',
        ];
    }
}
