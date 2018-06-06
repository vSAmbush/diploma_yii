<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 06.06.2018
 * Time: 14:18
 */

namespace app\models;


use yii\db\ActiveRecord;

class Provider extends ActiveRecord
{
    /**
     * @return string table name
     */
    public static function tableName()
    {
        return "providers";
    }

    /**
     * @param $id
     * @return null|static
     */
    public static function findProviderById($id) {
        return self::findOne(['id' => $id]);
    }

    /**
     * @return string
     */
    public function getOrgName() {
        return $this->org_name;
    }

    /**
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPhone() {
        return $this->phone;
    }
}