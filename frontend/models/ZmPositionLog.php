<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "zm_position_log".
 *
 * @property string $id
 * @property string $users_id
 * @property string $uname
 * @property integer $level
 * @property string $pid
 * @property string $rid
 * @property string $week1
 * @property string $week2
 * @property string $week3
 * @property string $pweek1
 * @property string $pweek2
 * @property string $pweek3
 * @property string $points_all
 * @property string $points_old
 * @property string $up_time
 * @property integer $status
 * @property integer $sdlevel
 * @property string $r_vip_num
 */
class ZmPositionLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zm_position_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'users_id' => 'Users ID',
            'level' => 'Level',
            'old_level' => 'Old Level',
            'add_time' => 'Add Time'
        ];
    }
}
