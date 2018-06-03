<?php

namespace app\controllers;

use app\helpers\ContactForm;
use app\helpers\LoginForm;
use app\helpers\ProductViewer;
use app\helpers\SignUpForm;
use app\models\Cart;
use app\models\Mark;
use app\models\Order;
use app\models\Product;
use app\models\Type;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

class SiteController extends Controller
{
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
        return $this->render('index');
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
            if(!($row = Cart::isRowExists($id_product))) {
                $cart = new Cart();
                $cart->id_user = Yii::$app->user->identity->getId();
                $cart->id_product = $id_product;
                $cart->amount = (Yii::$app->request->post('product_amount'));
                $cart->save();
            }
            else {
                $cart = $row;
                $cart->amount = Yii::$app->request->post('product_amount');;
                $cart->save();
            }
        }

        return $this->render('products', [
            'product_viewer' => $product_viewer,
            'marks' => $product_viewer->getMarks(),
            'types' => $product_viewer->getTypes(),
            'products' => $product_viewer->getProducts(),
            'others' => $product_viewer->getOthers(),
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
            if(!($row = Cart::isRowExists($id_product))) {
                $cart = new Cart();
                $cart->id_user = Yii::$app->user->identity->getId();
                $cart->id_product = $id_product;
                $cart->amount = (Yii::$app->request->post('product_amount'));
                $cart->save();
            }
            else {
                $cart = $row;
                $cart->amount = Yii::$app->request->post('product_amount');;
                $cart->save();
            }
        }

        for($i = 0; $i < count($products); $i++) {
            $products[$i]->mark = (Mark::findMarkById($products[$i]->id_mark)) ? Mark::findMarkById($products[$i]->id_mark)->getImgPath() : '';
            $products[$i]->type = Type::findTypeById($products[$i]->id_type)->getImgPath();
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

        $order_products = [];
        $products = [];
        for ($i = 0; $i < count($orders); $i++) {
            $order_products[] = json_decode($orders[$i]['products'], true);
            for($j = 0; $j < count($order_products[$i]); $j++) {
                $products[$i][$j] = Product::getProductById($order_products[$i][$j]['id_product'])[0];
                $products[$i][$j]['amount'] = $order_products[$i][$j]['amount'];
            }
        }

        if(Yii::$app->user->isGuest || Yii::$app->user->identity->getStatus()) {
            return $this->redirect(['site/login']);
        }
        else {
            return $this->render('purchases', [
                'orders' => $orders,
                'products' => $products,
            ]);
        }
    }

    public function actionCart() {

        $products = Cart::getCart(Yii::$app->user->identity->getId());

        $total = 0;
        for($i = 0; $i < count($products); $i++) {
            if($products[$i]['amount'] != 1)
                $products[$i]['cost'] *= $products[$i]['amount'];
            $total += $products[$i]['cost'];
        }

        if(Yii::$app->request->post('remove')) {
            Cart::deleteItem(Yii::$app->request->post('remove'));
            return $this->refresh();
        }

        if(Yii::$app->request->post('clear')) {
            Cart::clearCart(Yii::$app->user->identity->getId());
            return $this->refresh();
        }

        if(Yii::$app->request->post('checkout')) {
            $order = new Order();
            $temp = [];
            for($i = 0; $i < count($products); $i++) {
                $temp[$i]['id_product'] = $products[$i]['id_product'];
                $temp[$i]['amount'] = Yii::$app->request->post('product_amount'.$i);
            }
            $order->id_user = Yii::$app->user->identity->getId();
            $order->products = json_encode($temp);
            $order->cost = Yii::$app->request->post('total_input');
            $order->status = 0;
            $order->save();
            Cart::clearCart($order->id_user);
            return $this->refresh();
        }

        if(!Yii::$app->user->isGuest) {
            return $this->render('cart', [
                'products' => $products,
                'total' => $total,
            ]);
        } else {
            return $this->redirect(['site/login']);
        }
    }
}
