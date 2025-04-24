<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'category_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\app\models\Category::find()->orderBy('ordering')->all(), 'id', 'name'),
        ['prompt' => 'Select Category']
    ) ?>


    <?= $form->field($model, 'status')->checkbox([
        'label' => 'Active',
        'uncheck' => 0,
        'checked' => $model->status == 1 ? true : false,
    ]) ?>


    <?= $form->field($model, 'imageFile')->fileInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
