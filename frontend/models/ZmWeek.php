<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "zm_week".
 *
 * @property integer $id
 * @property integer $scount
 * @property integer $stime
 * @property integer $etime
 * @property string $curwk
 * @property string $nextwk
 * @property integer $status
 */
class ZmWeek extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zm_week';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['scount', 'stime', 'etime', 'status'], 'integer'],
            [['curwk', 'nextwk'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'scount' => 'Scount',
            'stime' => 'Stime',
            'etime' => 'Etime',
            'curwk' => 'Curwk',
            'nextwk' => 'Nextwk',
            'status' => 'Status',
        ];
    }
}
