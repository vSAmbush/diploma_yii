<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 21.05.2018
 * Time: 10:26
 */

namespace app\models;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Query;

class Order extends ActiveRecord
{
    public $orderItem;

    public $user;

    /**
     * @return string table name
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * Getting all orders
     *
     * @return Order[]|OrderItem[]|array|ActiveRecord[]
     */
    public static function getOrders() {
        $orders = self::find()->where(['status' => 0])->groupBy('order_number')->all();

        for($i = 0; $i < count($orders); $i++) {
            $orders[$i]->orderItem = OrderItem::findOrderItemByID($orders[$i]->getIdOrderItem());
            $orders[$i]->user = User::findIdentity($orders[$i]->getIdUser());
        }

        return $orders;
    }

    /**
     * @param $order_number
     * @return Order[]|OrderItem[]|array|ActiveRecord[]
     */
    public static function getOrderByOrderNumber($order_number) {
        $orders = self::find()
            ->where(['order_number' => $order_number])
            ->all();

        for($i = 0; $i < count($orders); $i++) {
            $orders[$i]->orderItem = OrderItem::findOrderItemById($orders[$i]->getIdOrderItem());
            $orders[$i]->user = User::findIdentity($orders[$i]->getIdUser());
        }

        return $orders;
    }

    /**
     * Getting last order
     *
     * @return integer
     */
    public static function getLastOrderNumber() {
        return self::find()->max('order_number');
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
    public function getIdUser() {
        return $this->id_user;
    }

    /**
     * @return integer
     */
    public function getIdOrderItem() {
        return $this->id_order_item;
    }

    /**
     * @return integer
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * @return integer
     */
    public function getOrderNumber() {
        return $this->order_number;
    }

    /**
     * @return integer
     */
    public function getCreatedAt() {
        return $this->created_at;
    }

    /**
     * @return User
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @return OrderItem
     */
    public function getOrderItem() {
        return $this->orderItem;
    }
}