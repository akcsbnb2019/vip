<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "zm_position".
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
class ZmPosition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zm_position';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['users_id', 'level', 'pid', 'rid', 'up_time', 'status', 'sdlevel', 'r_vip_num'], 'integer'],
            [['uname'], 'required'],
            [['week1', 'week2', 'week3', 'pweek1', 'pweek2', 'pweek3', 'points_all', 'points_old'], 'number'],
            [['uname'], 'string', 'max' => 50],
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
            'uname' => 'Uname',
            'level' => 'Level',
            'pid' => 'Pid',
            'rid' => 'Rid',
            'week1' => 'Week1',
            'week2' => 'Week2',
            'week3' => 'Week3',
            'pweek1' => 'Pweek1',
            'pweek2' => 'Pweek2',
            'pweek3' => 'Pweek3',
            'points_all' => 'Points All',
            'points_old' => 'Points Old',
            'up_time' => 'Up Time',
            'status' => 'Status',
            'sdlevel' => 'Sdlevel',
            'r_vip_num' => 'R Vip Num',
        ];
    }
}
