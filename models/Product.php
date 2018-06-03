<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 19.05.2018
 * Time: 10:19
 */

namespace app\models;


use yii\db\ActiveRecord;
use yii\db\Query;

class Product extends ActiveRecord
{
    public $type;

    public $mark;

    /**
     * @return string table name
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * @param $code
     * @return Product[]|array|ActiveRecord[]
     */
    public static function getProductsByCode($code) {
        return self::find()
            ->where(['code' => $code])
            ->all();
    }

    /**
     * @param $id
     * @return null|static
     */
    public static function getProductById($id) {
        return (new Query())
            ->select('code, products.name, org_name')
            ->from('products')
            ->where(['products.id' => $id])
            ->innerJoin('providers', 'id_provider = providers.id')
            ->all();
    }

    /**
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return string code of product
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * @return string name of product
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return float cost of product
     */
    public function getCost() {
        return $this->cost;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getMark()
    {
        return $this->mark;
    }
}