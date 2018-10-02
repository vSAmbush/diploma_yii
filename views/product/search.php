<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 03.06.2018
 * Time: 19:53
 */
/* @var $this \yii\web\View */
/* @var $products \app\models\Product[]|array|\yii\db\ActiveRecord[] */
/* @var $src  */

use yii\helpers\Html;

$this->title = "Search";
$this->params['breadcrumbs'][] = [
        'label' => 'Products',
        'url' => ['product/index'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-search">
    <h1><?= Html::encode($this->title); ?></h1>

    <?php if($products): ?>
        <table id="table_prod" class="table table-bordered">
            <?php for($i = 0; $i < count($products); $i++) : ?>
                <?= Html::beginForm(['order/add-cart']);?>
                <tr class="h4">
                    <?php if($products[$i]->getMark()) : ?>
                        <td class="col-xs-1 text-center"><?= Html::img($src.$products[$i]->getMark()->getImgPath(), [
                                'width' => '50%',
                            ]); ?></td>
                    <?php else: ?>
                    <td class="col-xs-1"></td>
                    <?php endif; ?>
                    <td class="col-md-1 text-center"><?= Html::img($src.$products[$i]->getType()->getImgPath(), [
                            'width' => '50%',
                        ]); ?></td>
                    <td class="col-md-1 bg-info">Code:</td>
                    <td class="col-md-2"><?= $products[$i]->getCode(); ?></td>
                    <td class="col-md-1 bg-info">Name:</td>
                    <td class="col-md-3"><?= $products[$i]->getName(); ?></td>
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
    <?php else : ?>
        <h1>No products were found for this article.</h1>
    <?php endif; ?>
</div>
