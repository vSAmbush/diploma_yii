<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 02.06.2018
 * Time: 21:44
 */

namespace app\models;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Purchase extends ActiveRecord
{

    public static function tableName()
    {
        return 'purchases';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
}