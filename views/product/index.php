<?php

use app\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ProductSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
                'attribute' => 'description',
                'format' => 'raw',
                'value' => function($model) {
                    return empty($model->description) ? '(No description)' : $model->description;
                },
            ],
            [
                'attribute' => 'category_id',
                'value' => function ($model) {
                    return $model->category ? $model->category->name : '(not set)';
                },
                'filter' => \yii\helpers\ArrayHelper::map(
                    \app\models\Category::find()->orderBy('name')->all(), 'id', 'name'
                ),
                'label' => 'Category',
            ],

            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return $model->status == 1 ? 'Active' : 'Inactive';
                },
                'filter' => [
                    1 => 'Active',
                    0 => 'Inactive',
                ],
            ],

            [
                'attribute' => 'image',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->image
                        ? Html::img(Yii::getAlias('@web') . '/' . $model->image, ['width' => '80px', 'style' => 'border-radius: 8px;'])
                        : '(No image)';
                },
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Product $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
