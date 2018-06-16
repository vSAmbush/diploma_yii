<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

/* @var $model \app\models\SignUpForm */


$this->title = 'Sign Up';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signUp">

    <h1><?= \yii\helpers\Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to sign up:</p>

    <?php $form = \yii\bootstrap\ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]); ?>

        <?= $form->field($model, 'first_name')->textInput(); ?>

        <?= $form->field($model, 'second_name')->textInput(); ?>

        <?= $form->field($model, 'email')->textInput(); ?>

        <?= $form->field($model, 'password1')->passwordInput(); ?>

        <?= $form->field($model, 'password2')->passwordInput(); ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-3">
                <?= Html::submitButton('Sign Up', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
        </div>

    <?php \yii\bootstrap\ActiveForm::end(); ?>
</div>
