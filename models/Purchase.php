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
    public $user;

    public $order;

    public $provider;

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

    /**
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return integer
     */
    public function getPurchaseNumber() {
        return $this->purchase_number;
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
    public function getIdOrder() {
        return $this->id_order;
    }

    /**
     * @return integer
     */
    public function getIdProvider() {
        return $this->id_provider;
    }

    /**
     * @return float
     */
    public function getCost() {
        return $this->cost;
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
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return Provider
     */
    public function getProvider()
    {
        return $this->provider;
    }
}