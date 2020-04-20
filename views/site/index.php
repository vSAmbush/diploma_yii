<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $src mixed */

$this->title = 'Diploma';

?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Welcome to auto parts shop!</h1>

        <div class="form-group">
            <?php

                for($i = 0; $i < 3; $i++) {
                    if($i === 1)
                        echo Html::img($src.'/images/gear'.$i.'.png', [
                                'width' => '20%',
                                'height' => '20%',
                                'class' => 'gear-left'
                            ]).' ';
                    else
                        echo Html::img($src.'/images/gear'.$i.'.png', [
                            'width' => '20%',
                            'height' => '20%',
                            'class' => 'gear-right'
                        ]).' ';
                }
                ?>
        </div>

        <p class="lead">If you want to place an order in our store, you need to register or log in.<br>You can also view the products offered by our company.</p>
    </div>

    <div class="form-group text-center">

        <?= Yii::$app->user->isGuest ? Html::a('Login', ['user/login'], ['class' => 'btn btn-primary btn-lg']) : '' ?>

        <?= Yii::$app->user->isGuest ? Html::a('Sing Up', ['user/sign-up'], ['class' => 'btn btn-success btn-lg']) : ''; ?>

        <?= Yii::$app->user->isGuest ? Html::a('View products', ['product/index'], ['class' => 'btn btn-default btn-lg']) :
            Html::a('View products', ['product/index'], ['class' => 'btn btn-success btn-lg']); ?>
    </div>
</div>