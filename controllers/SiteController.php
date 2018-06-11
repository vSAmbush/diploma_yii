<?php

namespace app\controllers;

use app\helpers\ContactForm;
use app\helpers\LoginForm;
use app\helpers\ProductViewer;
use app\helpers\SignUpForm;
use app\models\Cart;
use app\models\Mark;
use app\models\Order;
use app\models\OrderItem;
use app\models\Product;
use app\models\Type;
use Yii;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

class SiteController extends Controller
{
    public $src;

    public function __construct($id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->src = explode('?', $_SERVER['REQUEST_URI'])[0];
        $this->src = str_replace('/index.php', '', $this->src);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Handling homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'src' => $this->src,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Handling contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Handling products page.
     *
     * @return string
     */
    public function actionProducts()
    {
        if(Yii::$app->request->post('search_submit') && Yii::$app->request->post('search')) {
            $this->redirect(['site/search', 'code' => Yii::$app->request->post('search')]);
        }

        $product_viewer = new ProductViewer(Yii::$app->request->get('mark'), Yii::$app->request->get('type'),
            Yii::$app->request->get('other'));

        //handling 'buy' button
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

        return $this->render('products', [
            'product_viewer' => $product_viewer,
            'marks' => $product_viewer->getMarks(),
            'types' => $product_viewer->getTypes(),
            'products' => $product_viewer->getProducts(),
            'others' => $product_viewer->getOthers(),
            'src' => $this->src,
        ]);
    }

    /**
     * Handling searching page
     *
     * @return string
     */
    public function actionSearch() {

        $products = Product::getProductsByCode(Yii::$app->request->get('code'));

        //handling 'buy' button
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
        return $this->render('search', [
            'products' => $products,
        ]);
    }

    /**
     * Handling sign Up page.
     *
     * @return Response|string
     */
    public function actionSignup() {

        $model = new SignUpForm();

        if($model->load(Yii::$app->request->post()) && $model->register()) {

            return $this->redirect(['site/login']);
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

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
            return $this->redirect(['site/login']);
        }
        else {
            return $this->render('purchases', [
                'orders' => $orders,
                'total' => $total,
                'products' => $products,
            ]);
        }
    }

    public function actionCart() {

        $order_items = OrderItem::getCart(Yii::$app->user->identity->getId());

        $total = 0;
        for($i = 0; $i < count($order_items); $i++) {
            if($order_items[$i]->getAmount() != 1)
                $order_items[$i]->cost *= $order_items[$i]->getAmount();
            $total += $order_items[$i]->getCost();
        }

        if(Yii::$app->request->post('remove')) {
            OrderItem::deleteItem(Yii::$app->request->post('remove'));
            return $this->refresh();
        }

        if(Yii::$app->request->post('clear')) {
            OrderItem::clearCart(Yii::$app->user->identity->getId());
            return $this->refresh();
        }

        if(Yii::$app->request->post('checkout')) {

            $last = (Order::getLastOrderNumber()) ? (Order::getLastOrderNumber() + 1) : 1;
            for($i = 0; $i < count($order_items); $i++) {
                $order_items[$i]->amount = Yii::$app->request->post('product_amount'.$i);
                $order_items[$i]->cost = $order_items[$i]->getProduct()->getCost() * $order_items[$i]->getAmount();
                $order_items[$i]->status = 1;
                $order_items[$i]->save();

                $order = new Order();

                $order->id_user = Yii::$app->user->identity->getId();
                $order->order_number = $last;
                $order->id_order_item = $order_items[$i]->getId();
                $order->status = 0;
                $order->save();
            }
            //OrderItem::clearCart($order->id_user);
            return $this->refresh();
        }

        if(!Yii::$app->user->isGuest) {
            return $this->render('cart', [
                'order_items' => $order_items,
                'total' => $total,
            ]);
        } else {
            return $this->redirect(['site/login']);
        }
    }
}
