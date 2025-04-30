<?php

namespace app\widgets;

use app\models\Category;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class CategoryFilterWidget extends Widget
{
    public $name = 'category_id';
    public $value = null;
    public $prompt = 'All';

    public function run()
    {
        $categories = ArrayHelper::map(Category::find()->orderBy('name')->all(), 'id', 'name');

        return Html::dropDownList(
            $this->name,
            $this->value,
            $categories,
            [
                'class' => 'form-control',
                'prompt' => $this->prompt,
            ]
        );
    }
}
