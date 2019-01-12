<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

use yii\bootstrap\Html;

$show = "";

$show .= Html::tag('h1', "Добро пожаловать!");
$show .= Html::tag('h4', "Доступные призы!");

$showTR = "";
$showTd = Html::tag('th', 'Название', ['scope' => 'col']);
$showTd .= Html::tag('th', 'Количество', ['scope' => 'col']);
$showTR .= Html::tag('tr', $showTd);

foreach($good as $item)
{
    $showTd = Html::tag('td', $item['item']['name']);
    $showTd .= Html::tag('td', $item['amount']);
    $showTR .= Html::tag('tr', $showTd);
}
$showTable = Html::tag('table', $showTR, ['class' => 'table table-bordered']);

$show .= $showTable;

echo $show;

