<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "zm_position".
 *
 * @property string $id
 * @property string $users_id
 * @property string $uname
 * @property integer $level
 * @property integer $max_level
 * @property integer $second_level
 * @property string $pid
 * @property string $rid
 * @property string $points_all
 * @property string $points_old
 * @property string $week1
 * @property string $week2
 * @property string $week3
 * @property string $fweek1
 * @property string $fweek2
 * @property string $fweek3
 * @property string $vweek1
 * @property string $vweek2
 * @property string $vweek3
 * @property string $pweek1
 * @property string $pweek2
 * @property string $pweek3
 * @property string $bweek1
 * @property string $bweek2
 * @property string $bweek3
 * @property string $up_time
 * @property integer $status
 * @property integer $sdlevel
 * @property string $r_vip_num
 * @property string $absolute
 * @property integer $abs_area
 * @property integer $pan
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
            [['users_id', 'level', 'max_level', 'second_level', 'pid', 'rid', 'up_time', 'status', 'sdlevel', 'r_vip_num', 'abs_area', 'pan'], 'integer'],
            [['uname'], 'required'],
            [['points_all', 'points_old', 'week1', 'week2', 'week3', 'fweek1', 'fweek2', 'fweek3', 'vweek1', 'vweek2', 'vweek3', 'pweek1', 'pweek2', 'pweek3', 'bweek1', 'bweek2', 'bweek3', 'absolute'], 'number'],
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
            'max_level' => 'Max Level',
            'second_level' => 'Second Level',
            'pid' => 'Pid',
            'rid' => 'Rid',
            'points_all' => 'Points All',
            'points_old' => 'Points Old',
            'week1' => 'Week1',
            'week2' => 'Week2',
            'week3' => 'Week3',
            'fweek1' => 'Fweek1',
            'fweek2' => 'Fweek2',
            'fweek3' => 'Fweek3',
            'vweek1' => 'Vweek1',
            'vweek2' => 'Vweek2',
            'vweek3' => 'Vweek3',
            'pweek1' => 'Pweek1',
            'pweek2' => 'Pweek2',
            'pweek3' => 'Pweek3',
            'bweek1' => 'Bweek1',
            'bweek2' => 'Bweek2',
            'bweek3' => 'Bweek3',
            'up_time' => 'Up Time',
            'status' => 'Status',
            'sdlevel' => 'Sdlevel',
            'r_vip_num' => 'R Vip Num',
            'absolute' => 'Absolute',
            'abs_area' => 'Abs Area',
            'pan' => 'Pan',
        ];
    }
}
