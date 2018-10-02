<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 20.05.2018
 * Time: 13:34
 */
/* @var $this \yii\web\View */
/* @var $order_items \app\models\OrderItem[]|array|\yii\db\ActiveRecord[] */
/* @var $total int|mixed */
/* @var $src  */

use yii\helpers\Html;

$this->title = "Cart";
$this->params['breadcrumbs'][] = [
        'label' => 'Products',
        'url' => ['product/index'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-cart">
    <h1><?= Html::encode($this->title); ?></h1>

    <?php if($order_items) : ?>
        <div class="panel pull-right">
            <?= Html::beginForm(['order/clear-cart']); ?>
                <?= Html::submitButton('Clear cart', [
                    'class' => 'btn btn-danger',
                    'name' => 'clear',
                    'value' => 'clear',
                ]); ?>
            <?= Html::endForm(); ?>
        </div>
        <!-- Cart -->
        <?= Html::beginForm(['order/checkout']); ?>
            <table id="table_prod" class="table table-bordered">
                <?php for($i = 0; $i < count($order_items); $i++) : ?>
                        <tr class="h4">
                            <?php if($order_items[$i]->getProduct()->getMark()) : ?>
                                <td class="col-xs-1 text-center"><?= Html::img($src.$order_items[$i]->getProduct()->getMark()->getImgPath(), [
                                        'width' => '50%',
                                    ]); ?></td>
                            <?php else: ?>
                                <td class="col-xs-1"></td>
                            <?php endif; ?>
                            <td class="col-md-1 text-center"><?= Html::img($src.$order_items[$i]->getProduct()->getType()->getImgPath(), [
                                    'width' => '50%',
                                ]); ?></td>
                            <td class="col-md-1 bg-info">Code:</td>
                            <td class="col-md-2"><?= $order_items[$i]->getProduct()->getCode(); ?></td>
                            <td class="col-md-1 bg-info">Name:</td>
                            <td class="col-md-3"><?= $order_items[$i]->getProduct()->getName(); ?></td>
                            <td class="col-xs-2 col-sm-2 text-center">
                                <div class="counter">
                                    <span id="<?= 'counter-minus'.$i ?>" class="glyphicon glyphicon-minus counter-minus"></span>
                                    <?= Html::textInput('product_amount'.$i, $order_items[$i]->getAmount(), [
                                        'id' => 'counter'.$i,
                                        'class' => 'text-center',
                                        'readOnly' => true,
                                    ]); ?>
                                    <span id="<?= 'counter-plus'.$i ?>" class="glyphicon glyphicon-plus counter-plus"></span>
                                </div>
                            </td>
                            <td id="<?= 'td_cost'.$i; ?>" class="col-md-1 bg-danger text-center"><?= $order_items[$i]->getCost(); ?> $</td>
                            <td class="col-md-1 text-center"><?= Html::a('<span class="glyphicon glyphicon-remove"></span>', [
                                   'order/remove-from-cart',
                                    'remove' => $order_items[$i]->getId(),
                                ], [
                                    'class' => 'btn btn-default',
                                ]); ?></td>
                        </tr>
                <?php endfor; ?>
            </table>

        <p id="total" class="btn btn-info btn-lg disabled pull-right">Total: <?= $total ?> $</p>

            <!-- Checkout -->
            <br><br><br>
            <div class="panel pull-right">
                    <?= Html::submitButton('Checkout', [
                        'class' => 'btn btn-primary btn-lg',
                        'name' => 'checkout',
                        'value' => 'checkout',
                    ]); ?>
            </div>
        <?= Html::endForm(); ?>
    <?php else : ?>
        <h1>The cart is empty!</h1>
    <?php endif; ?>
</div>