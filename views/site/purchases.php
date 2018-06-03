<?php
/* @var $this \yii\web\View */
/* @var $orders \app\models\Order[]|array|\yii\db\ActiveRecord[] */
/* @var $products array */

use yii\helpers\Html;

$this->title = "Purchases";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1>Orders</h1>

    <?php if($orders): ?>
        <?php for($i = 0; $i < count($orders); $i++): ?>
            <div class="row panel panel-default panel-body h4">
                <div class="col-sm-1">Name: </div>
                <div class="col-xs-6"><?= $orders[$i]['first_name'].' '.$orders[$i]['second_name'] ?></div>
                <div class="col-sm-2 text-center"><?= $orders[$i]['cost'] ?> $</div>
                <div class="col-sm-2"><?= date('d.m.Y H:m', $orders[$i]['created_at']) ?></div>
                <div class="col-xs-1 text-center">
                    <button class="btn btn-default shower" id="<?= 'display'.$i ?>">
                        <span class="glyphicon glyphicon-chevron-down"></span>
                    </button>
                </div>
            </div>

            <table class="table table-bordered d-none" id="<?= 'tab_display'.$i ?>">
                <?php for($j = 0; $j < count($products[$i]); $j++) : ?>
                    <tr class="h4">
                        <td class="col-md-1 bg-info">Code: </td>
                        <td class="col-md-2"><?= $products[$i][$j]['code'] ?></td>
                        <td class="col-md-1 bg-info">Product Name: </td>
                        <td class="col-md-2"><?= $products[$i][$j]['name'] ?></td>
                        <td class="col-md-1 bg-info">Amount: </td>
                        <td class="col-md-1"><?= $products[$i][$j]['amount'] ?></td>
                        <td class="col-md-1 bg-info">Provider Name: </td>
                        <td class="col-md-2"><?= $products[$i][$j]['org_name'] ?></td>
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
