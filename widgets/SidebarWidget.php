<?php

namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Url;
use yii\helpers\Html;

class SidebarWidget extends Widget
{
    public array $items = [];

    public function run()
    {
        $links = '';
        foreach ($this->items as $item) {
            $links .= Html::a(
                "<i class='{$item['icon']}'></i> {$item['label']}",
                Url::to($item['url']),
                ['class' => 'nav-link']
            );
        }

        return Html::tag('aside',
            Html::tag('nav', $links, ['class' => 'nav flex-column']),
            ['class' => 'sidebar bg-light']
        );
    }
}

