<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 15.06.2018
 * Time: 23:17
 */

namespace app\controllers;


use app\helpers\LoginForm;
use app\helpers\SignUpForm;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class UserController extends Controller
{

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
     * Handling sign Up page.
     *
     * @return Response|string
     */
    public function actionSignUp() {

        $model = new SignUpForm();

        if($model->load(Yii::$app->request->post()) && $model->register()) {

            return $this->redirect(['user/login']);
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
}