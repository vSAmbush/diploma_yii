<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 19.05.2018
 * Time: 10:35
 */

namespace app\models;


use yii\db\ActiveRecord;

class Mark extends ActiveRecord
{
    /**
     * @return string table name
     */
    public static function tableName()
    {
        return 'marks';
    }

    /**
     * Finds auto mark by it's id
     *
     * @param $id_mark
     * @return null|static
     */
    public static function findMarkById($id_mark) {
        return self::findOne(['id' => $id_mark]);
    }

    /**
     * @return Mark[]|array|ActiveRecord[]
     */
    public static function getAllMarks() {
        return self::find()->all();
    }

    /**
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getMark() {
        return $this->mark;
    }

    /**
     * @return string
     */
    public function getImgPath() {
        return $this->img_path;
    }
}