<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 15.06.2018
 * Time: 23:49
 */

namespace app\controllers;


use app\helpers\ProductViewer;
use app\models\Product;
use Yii;
use yii\web\Controller;

class ProductController extends Controller
{

    /**
     * Handling products page.
     *
     * @return string
     */
    public function actionIndex()
    {

        $product_viewer = new ProductViewer(Yii::$app->request->get('mark'), Yii::$app->request->get('type'),
            Yii::$app->request->get('other'));

        return $this->render('products', [
            'product_viewer' => $product_viewer,
            'marks' => $product_viewer->getMarks(),
            'types' => $product_viewer->getTypes(),
            'products' => $product_viewer->getProducts(),
            'others' => $product_viewer->getOthers(),
            'src' => Yii::$app->params['img_src'],
        ]);
    }

    /**
     * Handling searching page
     *
     * @return string
     */
    public function actionSearch() {

        $products = Product::getProductsByCode(Yii::$app->request->get('code'));

        return $this->render('search', [
            'products' => $products,
            'src' => Yii::$app->params['img_src'],
        ]);
    }
}