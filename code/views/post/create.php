<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\PostForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Create post';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-createpost">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to createpost:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'createpost-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-3 form-control'],
            'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
        ],
    ]); ?>

        <?= $form->field($model, 'title')->textInput(['autofocus' => true, 'max' => '255']) ?>
        <?= $form->field($model, 'description')->textarea(['max' => '5000']) ?>
        <?= $form->field($model, 'is_for_authorization_user')->checkbox() ?>

        <div class="form-group">
            <div class="offset-lg-1 col-lg-11">
                <?= Html::submitButton('Create post', ['class' => 'btn btn-primary', 'name' => 'createpost-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
</div>
