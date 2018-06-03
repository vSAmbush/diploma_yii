<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 19.05.2018
 * Time: 10:38
 */

namespace app\models;


use yii\db\ActiveRecord;

class Type extends ActiveRecord
{
    /**
     * @return string table name
     */
    public static function tableName()
    {
        return 'types';
    }

    /**
     * Finds type product by it's id
     *
     * @param $id_type
     * @return null|static
     */
    public static function findTypeById($id_type) {
        return self::findOne(['id' => $id_type]);
    }

    /**
     * @return Mark[]|Type[]|array|ActiveRecord[]
     */
    public static function getAllTypes() {
        return self::find()->indexBy('id')->all();
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
    public function getType() {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getImgPath() {
        return $this->img_path;
    }
}