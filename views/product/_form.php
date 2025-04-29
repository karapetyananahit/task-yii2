<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
use dosamigos\ckeditor\CKEditor;
?>

<div class="product-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'enableAjaxValidation' => false,
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>


    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->widget(CKEditor::class, [
        'options' => ['rows' => 3],
        'clientOptions' => [
            'toolbar' => [
                ['name' => 'basicstyles', 'items' => ['Bold', 'Italic']],
                ['name' => 'paragraph', 'items' => ['NumberedList', 'BulletedList']],
                ['name' => 'clipboard', 'items' => ['Undo', 'Redo']],
            ],
            'removePlugins' => 'elementspath',
            'resize_enabled' => false,
        ],
    ]) ?>

    <?= $form->field($model, 'category_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\app\models\Category::find()->orderBy('ordering')->all(), 'id', 'name'),
        [
            'prompt' => 'Select Category',
        ]
    ) ?>


    <?= $form->field($model, 'status')->checkbox([
        'label' => 'Active',
        'uncheck' => 0,
        'checked' => $model->status == 1 ? true : false,
    ]) ?>


    <div class="form-group">
        <div class="mb-3">
            <?= Html::img(
                $model->isNewRecord ? '' : Yii::getAlias('@web') . '/' . $model->image,
                [
                    'id' => 'previewImg',
                    'width' => '120px',
                    'style' => 'margin-top: 10px; border-radius: 8px; border: 1px solid #ddd;' . ($model->isNewRecord ? 'display: none;' : '')
                ]
            ) ?>
        </div>
        <?php if (!$model->isNewRecord && $model->image): ?>
        <?php endif; ?>
        <label for="imageFileUpload" class="btn btn-primary">
            Upload New Image
        </label>

        <?= $form->field($model, 'imageFile')->fileInput([
            'id' => 'imageFileUpload',
            'style' => 'display: none;',
            'accept' => 'image/*'
        ])->label(false) ?>


    </div>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJs("
    document.getElementById('imageFileUpload').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const reader = new FileReader();
        const previewImg = document.getElementById('previewImg');

        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewImg.style.display = 'block';
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    });
");
?>