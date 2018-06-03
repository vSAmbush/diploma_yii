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
     * Getting orders
     *
     * @return array
     */
    public static function getOrders() {
        return (new Query())
            ->select('first_name, second_name, products, cost, orders.created_at, orders.updated_at')
            ->from('orders')
            ->innerJoin('users', 'id_user = users.id')
            ->all();
    }
}