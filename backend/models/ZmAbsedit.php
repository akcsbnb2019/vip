<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "zm_absedit".
 *
 * @property integer $id
 * @property string $users_id
 * @property string $y_absolute
 * @property integer $y_abs_area
 * @property string $n_absolute
 * @property integer $n_abs_area
 * @property string $lallyeji
 * @property string $rallyeji
 * @property string $addtime
 * @property integer $types
 */
class ZmAbsedit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zm_absedit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['users_id', 'y_abs_area', 'n_abs_area', 'types'], 'integer'],
            [['y_absolute', 'n_absolute', 'lallyeji', 'rallyeji'], 'number'],
            [['addtime'], 'safe'],
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
            'y_absolute' => 'Y Absolute',
            'y_abs_area' => 'Y Abs Area',
            'n_absolute' => 'N Absolute',
            'n_abs_area' => 'N Abs Area',
            'lallyeji' => 'Lallyeji',
            'rallyeji' => 'Rallyeji',
            'addtime' => 'Addtime',
            'types' => 'Types',
        ];
    }
}
