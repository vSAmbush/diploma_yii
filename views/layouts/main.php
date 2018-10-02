<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/web/favicon.ico" type="image/x-icon">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '<span class="glyphicon glyphicon-wrench"></span> '.Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-inverse navbar-fixed-top',
        ],
    ]);

    if(!Yii::$app->user->isGuest) {
        $menuItems = [
            (Yii::$app->user->identity->getStatus() == 0) ? ['label' => 'Make a purchase', 'url' => ['purchase/purchases']] : '',
            ['label' => 'Products', 'url' => ['/product/index']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            '<li>'.Html::a('<span class="glyphicon glyphicon-shopping-cart"></span> Cart', ['/order/show-cart']).'</li>',
            '<li>'
            . Html::beginForm(['/user/logout'], 'post')
            . Html::submitButton(
                '<span class="glyphicon glyphicon-log-out"></span> Logout (' . Yii::$app->user->identity->getFirstName() . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>',
        ];
    } else {
        $menuItems = [
            ['label' => 'Products', 'url' => ['product/index']],
            '<li>'.Html::a('<span class="glyphicon glyphicon-user"></span> Sign Up', ['/user/sign-up']).'</li>',
            '<li>'.Html::a('<span class="glyphicon glyphicon-log-in"></span> Login', ['/user/login']).'</li>',
        ];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Hushquite <?= date('Y'); ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
