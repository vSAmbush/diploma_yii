<?php

/* @var $this yii\web\View */

$this->title = 'Diploma';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Welcome to auto parts shop!</h1>

        <div class="form-group">
            <?php

                for($i = 0; $i < 3; $i++) {
                    if($i === 1)
                        echo \yii\helpers\Html::img('/images/gear'.$i.'.png', [
                                'width' => '20%',
                                'height' => '20%',
                                'class' => 'gear-left'
                            ]).' ';
                    else
                        echo \yii\helpers\Html::img('/images/gear'.$i.'.png', [
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

        <?= Yii::$app->user->isGuest ? \yii\helpers\Html::a('Login', ['site/login'], ['class' => 'btn btn-primary btn-lg']) : '' ?>

        <?= Yii::$app->user->isGuest ? \yii\helpers\Html::a('Sing Up', ['site/signup'], ['class' => 'btn btn-success btn-lg']) : ''; ?>

        <?= Yii::$app->user->isGuest ? \yii\helpers\Html::a('View products', ['site/products'], ['class' => 'btn btn-default btn-lg']) :
            \yii\helpers\Html::a('View products', ['site/products'], ['class' => 'btn btn-success btn-lg']); ?>
    </div>
</div>