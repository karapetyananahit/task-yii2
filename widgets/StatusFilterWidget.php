<?php

namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class StatusFilterWidget extends Widget
{
    public $name = 'status';
    public $value = null;
    public $prompt = 'All';

    public function run()
    {
        $options = [
            1 => 'Active',
            0 => 'Inactive',
        ];

        return Html::dropDownList(
            $this->name,
            $this->value,
            $options,
            [
                'class' => 'form-control',
                'prompt' => $this->prompt,
            ]
        );
    }
}
