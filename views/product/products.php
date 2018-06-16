<?php

/* @var $this yii\web\View */
/* @var $product_viewer \app\helpers\ProductViewer */
/* @var $types mixed */
/* @var $marks mixed */
/* @var $products \app\models\Product[]|\app\models\Type[]|array|\yii\db\ActiveRecord[] */
/* @var $others \app\models\Product[]|\app\models\Type[]|array|\yii\db\ActiveRecord[] */
/* @var $src mixed */

use yii\helpers\Html;

$this->title = 'Products';
$this->params['breadcrumbs'][] = [
        'label' => 'Products',
        'url' => ['product/index'],
];
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if(!$product_viewer->isMarkSelected && !$product_viewer->isOtherSelected): ?>
        <?= Html::beginForm(['product/search'], 'get', [
                'class' => 'panel',
        ]); ?>
            <div class="form-group no-padding">
                <div class="col-xs-11">
                    <?= Html::textInput('code', '', [
                        'class' => 'form-control',
                        'placeholder' => 'Enter the detail code',
                    ]); ?>
                </div>
                <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span>', [
                        'class' => 'col-xs-1 btn btn-default',
                ])?>
            </div>
        <?= Html::endForm(); ?><br>
        <?php for($i = 0; $i < count($others); $i++): ?>
            <a class="btn btn-default" href="<?= \yii\helpers\Url::to(['product/index', 'other' => $others[$i]->getId()]);?>">
                <?= Html::img($src.$others[$i]->getImgPath(), [
                    'width' => '50px',
                    'height' => '50px',
                ]);?>
                <?= $others[$i]->getType() ?>
            </a>
        <?php endfor; ?>
        <br/><br/>
        <?php for($i = 0; $i < count($marks); $i++) : ?>
            <a class="btn btn-default" href="<?= \yii\helpers\Url::to(['product/index', 'mark' => $marks[$i]->getId()]);?>">
                <?= Html::img($src.$marks[$i]->getImgPath(), [
                    'width' => '150px',
                    'height' => '150px',
                    'class' => 'panel',
                ]);?>
                <p class="text-center"><?= $marks[$i]->getMark(); ?></p>
            </a>
        <?php endfor; ?>
    <?php else:
            if(!$product_viewer->isOtherSelected)
                $this->params['breadcrumbs'][] = [
                    'label' => 'Types ('.$product_viewer->getNameMarkById($product_viewer->currentMark).')',
                    'url' => [
                        'product/index',
                        'mark' => $product_viewer->currentMark
                    ],
                ];
            if(!$product_viewer->isTypeSelected && !$product_viewer->isOtherSelected):
                for($i = 0; $i < count($types); $i++) : ?>
                    <a class="btn btn-default" href="<?= \yii\helpers\Url::to(['product/index', 'mark' => $product_viewer->currentMark, 'type' => $types[$i]->getId()]);?>">
                        <?= Html::img($src.$types[$i]->getImgPath(), [
                            'width' => '150px',
                            'height' => '150px',
                            'class' => 'panel',
                        ]);?>
                        <p class="text-center"><?= $types[$i]->getType(); ?></p>
                    </a>
                <?php endfor; ?>
            <?php else:
                $this->params['breadcrumbs'][] = $product_viewer->getNameTypeById($product_viewer->currentType); ?>
                <table id="table_prod" class="table table-bordered">
                <?php for($i = 0; $i < count($products); $i++) : ?>
                        <?= Html::beginForm(['order/add-cart']);?>
                            <tr class="h4">
                                <td class="col-md-1 bg-info">Code:</td>
                                <td class="col-md-2"><?= $products[$i]->getCode(); ?></td>
                                <td class="col-md-1 bg-info">Name:</td>
                                <td class="col-md-4"><?= $products[$i]->getName(); ?></td>
                                <?php if(!Yii::$app->user->isGuest): ?>
                                    <td class="col-xs-2 col-sm-2 text-center">
                                        <div class="counter">
                                            <span id="<?= 'counter-minus'.$i ?>" class="glyphicon glyphicon-minus counter-minus"></span>
                                            <?= Html::textInput('product_amount', 1, [
                                                    'id' => 'counter'.$i,
                                                    'class' => 'text-center',
                                                    'readOnly' => true,
                                            ]); ?>
                                            <span id="<?= 'counter-plus'.$i ?>" class="glyphicon glyphicon-plus counter-plus"></span>
                                        </div>
                                    </td>
                                    <td id="<?= 'td_cost'.$i; ?>" class="col-md-2 bg-danger text-center"><?= $products[$i]->getCost(); ?> $</td>
                                    <td class="col-md-1 text-center"><?= Html::submitButton('<span class="glyphicon glyphicon-shopping-cart"></span>', [
                                            'value' => $products[$i]->getId(),
                                            'class' => 'btn btn-default',
                                            'name' => 'buy',
                                        ]); ?></td>
                                <?php endif; ?>
                            </tr>
                        <?= Html::endForm(); ?>
                <?php endfor; ?>
                </table>
            <?php endif; ?>
    <?php endif; ?>
</div>
