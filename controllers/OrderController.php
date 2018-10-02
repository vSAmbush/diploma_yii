<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 15.06.2018
 * Time: 23:57
 */

namespace app\controllers;


use app\models\Order;
use app\models\OrderItem;
use app\models\Product;
use Yii;
use yii\base\Module;
use yii\web\Controller;

class OrderController extends Controller
{
    public $order_items;

    /**
     * OrderController constructor.
     *
     * @param $id
     * @param Module $module
     * @param array $config
     */
    public function __construct($id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->order_items = OrderItem::getCart(Yii::$app->user->identity->getId());
    }

    /**
     * Handling 'buy' button
     *
     * @return \yii\web\Response
     */
    public function actionAddCart() {

        $id_product = Yii::$app->request->post('buy');
        if(isset($id_product)) {
            if(!($row = OrderItem::isRowExists($id_product))) {
                $order_item = new OrderItem();
                $order_item->id_user = Yii::$app->user->identity->getId();
                $order_item->id_product = $id_product;
                $order_item->amount = (Yii::$app->request->post('product_amount'));
                $order_item->cost = Product::getProductById($id_product)->getCost() * $order_item->amount;
                $order_item->status = 0;
                $order_item->save();
            }
            else {
                $order_item = $row;
                $order_item->amount = Yii::$app->request->post('product_amount');;
                $order_item->save();
            }
        }

        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    /**
     * Removing item from cart
     *
     * @return \yii\web\Response
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionRemoveFromCart() {

        OrderItem::deleteItem(Yii::$app->request->get('remove'));

        return $this->goBack(['order/show-cart']);
    }

    /**
     * Clearing cart
     *
     * @return \yii\web\Response
     */
    public function actionClearCart() {

        OrderItem::clearCart(Yii::$app->user->identity->getId());

        return $this->goBack(['order/show-cart']);
    }

    /**
     * Checkout
     *
     * @return \yii\web\Response
     */
    public function actionCheckout() {

        $last = (Order::getLastOrderNumber()) ? (Order::getLastOrderNumber() + 1) : 1;
        for($i = 0; $i < count($this->order_items); $i++) {
            $this->order_items[$i]->amount = Yii::$app->request->post('product_amount'.$i);
            $this->order_items[$i]->cost = $this->order_items[$i]->getProduct()->getCost() * $this->order_items[$i]->getAmount();
            $this->order_items[$i]->status = 1;
            $this->order_items[$i]->save();

            $order = new Order();

            $order->id_user = Yii::$app->user->identity->getId();
            $order->order_number = $last;
            $order->id_order_item = $this->order_items[$i]->getId();
            $order->status = 0;
            $order->save();
        }
        //OrderItem::clearCart($order->id_user);
        return $this->goBack(['order/show-cart']);
    }

    /**
     * Showing cart
     *
     * @return string|\yii\web\Response
     */
    public function actionShowCart() {

        $total = 0;
        for($i = 0; $i < count($this->order_items); $i++) {
            if($this->order_items[$i]->getAmount() != 1)
                $this->order_items[$i]->cost *= $this->order_items[$i]->getAmount();
            $total += $this->order_items[$i]->getCost();
        }

        if(!Yii::$app->user->isGuest) {
            return $this->render('cart', [
                'order_items' => $this->order_items,
                'total' => $total,
                'src' => Yii::$app->params['img_src'],
            ]);
        } else {
            return $this->redirect(['user/login']);
        }
    }
}