<?php
/* @var $this \yii\web\View */
/* @var $orders \app\models\Order[]|array|\yii\db\ActiveRecord[] */
/* @var $products array */
/* @var $totals  */
/* @var $total  */

use yii\helpers\Html;

$this->title = "Purchases";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1>Orders</h1>

    <?php if($orders): ?>
        <?php for($i = 0; $i < count($orders); $i++): ?>
            <div class="panel panel-default panel-body h4">
                <div id="<?= 'item'.$i ?>" class="row">
                    <div class="col-sm-1">Name: </div>
                    <div class="col-xs-5"><?= $orders[$i]->getUser()->getFirstName().' '.$orders[$i]->getUser()->getSecondName() ?></div>
                    <div class="col-sm-2 text-center"><?= $total[$i] ?> $</div>
                    <div class="col-sm-2"><?= date('d.m.Y H:m', $orders[$i]->getCreatedAt()) ?></div>
                    <div class="col-xs-2 text-center">
                        <button class="btn btn-default shower" id="<?= 'display'.$i ?>">
                            <span class="glyphicon glyphicon-chevron-down"></span>
                        </button>
                        <button class="btn btn-default checker" id="<?= 'check'.$i ?>">
                            <span class="glyphicon glyphicon-ok"></span>
                        </button>
                        <button class="btn btn-default decliner" id="<?= 'decline'.$i ?>">
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                    </div>
                </div>
            </div>

            <table class="table table-bordered d-none" id="<?= 'tab_display'.$i ?>">
                <?php for($j = 0; $j < count($products[$i]); $j++) : ?>
                    <tr class="h4">
                        <td class="col-md-1 bg-info">Code: </td>
                        <td class="col-md-2"><?= $products[$i][$j]->getOrderItem()->getProduct()->getCode() ?></td>
                        <td class="col-md-1 bg-info">Product Name: </td>
                        <td class="col-md-2"><?= $products[$i][$j]->getOrderItem()->getProduct()->getName() ?></td>
                        <td class="col-md-1 bg-info">Amount: </td>
                        <td class="col-md-1"><?= $products[$i][$j]->getOrderItem()->getAmount() ?></td>
                        <td class="col-md-1 bg-info">Provider Name: </td>
                        <td class="col-md-2"><?= $products[$i][$j]->getOrderItem()->getProduct()->getProvider()->getOrgName() ?></td>
                    </tr>
                <?php endfor; ?>
            </table>
        <?php endfor; ?>

        <?= Html::beginForm(); ?>
            <?= Html::submitButton('Make a purchase', [
                    'name' => 'makePurchase',
                    'value' => 'purchase',
                    'class' => 'btn btn-primary btn-lg pull-right',
            ]); ?>
        <?= Html::endForm(); ?>
    <?php else: ?>
        <h1>No orders yet!</h1>
    <?php endif; ?>
</div>
