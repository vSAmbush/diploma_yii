<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 28.05.2018
 * Time: 10:31
 */

namespace app\models;


use yii\db\ActiveRecord;

class OrderItem extends ActiveRecord
{
    public $product;

    /**
     * @return string
     */
    public static function tableName()
    {
        return "order_item";
    }

    /**
     * Validation rules
     *
     * @return array
     */
    public function rules()
    {
        return [
          ['id_product', 'unique'],
        ];
    }

    /**
     * @param $id
     * @return null|static
     */
    public static function findOrderItemById($id) {
        $item = self::findOne(['id' => $id]);
        $item->product = Product::getProductById($item->getIdProduct());
        return $item;
    }

    /**
     * Returns existing row or false
     *
     * @param $id_product
     * @return null|static
     */
    public static function isRowExists($id_product) {
        return self::findOne(['id_product' => $id_product]);
    }

    /**
     * Getting all bought products
     *
     * @param $id_user
     * @return OrderItem[]|array|ActiveRecord[]
     */
    public static function getCart($id_user) {
        $order_items = self::find()
            ->where(['id_user' => $id_user, 'status' => 0])
            ->all();
        for($i = 0; $i < count($order_items); $i++) {
            $order_items[$i]->product = Product::getProductById($order_items[$i]->getIdProduct());
            $order_items[$i]->cost = $order_items[$i]->product->getCost();
        }

        return $order_items;
    }

    /**
     * Delete item in cart
     *
     * @param $id
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function deleteItem($id) {
        $row = self::findOne(['id' => $id]);
        $row->delete();
    }

    /**
     * Clearing cart
     *
     * @param $id_user
     */
    public static function clearCart($id_user) {
        self::deleteAll(['id_user' => $id_user]);
    }

    /**
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return integer
     */
    public function getIdProduct() {
        return $this->id_product;
    }

    /**
     * @return integer
     */
    public function getIdUser() {
        return $this->id_user;
    }

    /**
     * @return integer
     */
    public function getAmount() {
        return $this->amount;
    }

    /**
     * @return float
     */
    public function getCost() {
        return $this->cost;
    }

    /**
     * @return Product
     */
    public function getProduct() {
        return $this->product;
    }

    /**
     * @return integer
     */
    public function getStatus() {
        return $this->status;
    }
}