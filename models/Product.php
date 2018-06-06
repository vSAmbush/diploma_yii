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

    public $provider;

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
        $products = self::find()
            ->where(['code' => $code])
            ->all();

        for($i = 0; $i < count($products); $i++) {
            $products[$i]->type = Type::findTypeById($products[$i]->getIdType());
            $products[$i]->mark = ($products[$i]->getIdMark()) ? Mark::findMarkById($products[$i]->getIdMark()) : null;
            $products[$i]->provider = Provider::findProviderById($products[$i]->getIdProvider());
        }

        return $products;
    }

    /**
     * @param $id
     * @return null|static
     */
    public static function getProductById($id) {
        $product = self::findOne(['id' => $id]);
        $product->type = Type::findTypeById($product->getIdType());
        $product->mark = ($product->getIdMark()) ? Mark::findMarkById($product->getIdMark()) : null;
        $product->provider = Provider::findProviderById($product->getIdProvider());

        return $product;
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
     * @return integer
     */
    public function getIdType() {
        return $this->id_type;
    }

    /**
     * @return integer
     */
    public function getIdMark() {
        return $this->id_mark;
    }

    /**
     * @return integer
     */
    public function getIdProvider() {
        return $this->id_provider;
    }

    /**
     * @return Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return Mark
     */
    public function getMark()
    {
        return $this->mark;
    }

    /**
     * @return Provider
     */
    public function getProvider() {
        return $this->provider;
    }
}