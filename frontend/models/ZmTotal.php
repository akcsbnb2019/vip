<?php

namespace frontend\models;

use Yii;
use frontend\models\Zmweek;


/**
 * This is the model class for table "zm_total".
 *
 * @property string $id
 * @property string $userid
 * @property string $bonus
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
            [['bonus'], 'number'],
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
            'addtime' => 'Addtime',
            'scount' => 'Scount',
        ];
    }
	
	public function getZmweek()
	{
		//同样第一个参数指定关联的子表模型类名
		return $this->hasOne(Zmweek::className(), ['scount' => 'scount']);
	}
}
