<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 16.06.2018
 * Time: 1:18
 */

namespace app\controllers;


use app\models\Order;
use Yii;
use yii\web\Controller;

class PurchaseController extends Controller
{

    /**
     * Handling admin page
     *
     * @return string
     */
    public function actionPurchases() {

        $orders = Order::getOrders();

        $total = [];
        $products = [];
        for($i = 0; $i < count($orders); $i++) {
            $total[$i] = 0;
            $products[] = Order::getOrdersByOrderNumber($orders[$i]->getOrderNumber());
            for($j = 0; $j < count($products[$i]); $j++)
                $total[$i] += $products[$i][$j]->getOrderItem()->getCost();
        }

        if(Yii::$app->user->isGuest || Yii::$app->user->identity->getStatus()) {
            return $this->redirect(['user/login']);
        }
        else {
            return $this->render('purchases', [
                'orders' => $orders,
                'total' => $total,
                'products' => $products,
            ]);
        }
    }
}