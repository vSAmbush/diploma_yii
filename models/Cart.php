<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 28.05.2018
 * Time: 10:31
 */

namespace app\models;


use yii\db\ActiveRecord;
use yii\db\Query;

class Cart extends ActiveRecord
{
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
     * @return Cart[]|array|ActiveRecord[]
     */
    public static function getCart($id_user) {
        return (new Query())
            ->select('cart.id, id_user, id_product, amount, code, name, cost, img_path, id_provider')
            ->from('cart')
            ->innerJoin('products', 'id_product = products.id')
            ->innerJoin('types', 'id_type = types.id')
            ->where(['id_user' => $id_user])
            ->all();
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
}