<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 20.05.2018
 * Time: 13:34
 */
/* @var $this \yii\web\View */
/* @var $products \app\models\Cart[]|array|\yii\db\ActiveRecord[] */
/* @var $total int|mixed */

use yii\helpers\Html;

$this->title = "Cart";
$this->params['breadcrumbs'][] = [
        'label' => 'Products',
        'url' => ['site/products'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-cart">
    <h1><?= Html::encode($this->title); ?></h1>

    <?php if($products) : ?>
        <div class="panel pull-right">
            <?= Html::beginForm(); ?>
                <?= Html::submitButton('Clear cart', [
                    'class' => 'btn btn-danger',
                    'name' => 'clear',
                    'value' => 'clear',
                ]); ?>
            <?= Html::endForm(); ?>
        </div>
        <!-- Cart -->
        <?= Html::beginForm(); ?>
            <table id="table_prod" class="table table-bordered">
                <?php for($i = 0; $i < count($products); $i++) : ?>
                        <tr class="h4">
                            <td class="col-md-1 text-center"><?= Html::img($products[$i]['img_path'], [
                                    'width' => '50%',
                                ]); ?></td>
                            <td class="col-md-1 bg-info">Code:</td>
                            <td class="col-md-2"><?= $products[$i]['code']; ?></td>
                            <td class="col-md-1 bg-info">Name:</td>
                            <td class="col-md-4"><?= $products[$i]['name']; ?></td>
                            <td class="col-xs-2 col-sm-2 text-center">
                                <div class="counter">
                                    <span id="<?= 'counter-minus'.$i ?>" class="glyphicon glyphicon-minus counter-minus"></span>
                                    <?= Html::textInput('product_amount'.$i, $products[$i]['amount'], [
                                        'id' => 'counter'.$i,
                                        'class' => 'text-center',
                                        'readOnly' => true,
                                    ]); ?>
                                    <span id="<?= 'counter-plus'.$i ?>" class="glyphicon glyphicon-plus counter-plus"></span>
                                </div>
                            </td>
                            <td id="<?= 'td_cost'.$i; ?>" class="col-md-1 bg-danger text-center"><?= $products[$i]['cost']; ?> $</td>
                            <td class="col-md-1 text-center"><?= Html::submitButton('<span class="glyphicon glyphicon-remove"></span>', [
                                    'value' => $products[$i]['id'],
                                    'class' => 'btn btn-default',
                                    'name' => 'remove',
                                ]); ?></td>
                        </tr>
                <?php endfor; ?>
            </table>

            <p id="total" class="btn btn-info btn-lg disabled pull-right">Total: <?= $total ?> $</p>
            <?= Html::hiddenInput('total_input', $total, [
                    'id' => 'total_input',
                ]);?>
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