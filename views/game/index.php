<?php
/**
 * Created by PhpStorm.
 * User: Френки
 * Date: 12.01.19
 * Time: 11:41
 */

use yii\bootstrap\Html;

$this->title = 'Игра';
echo $this->registerJsFile('@web/js/game.js', ['depends' => 'yii\web\YiiAsset']);

$show = "";

$show .= Html::tag('h1', "Добро пожаловать, $user_name!");

$showTR = "";
$showTd = Html::tag('th', 'Название', ['scope' => 'col']);
$showTd .= Html::tag('th', 'Количество', ['scope' => 'col']);
$showTd .= Html::tag('th', 'Действие', ['scope' => 'col']);
$showTR .= Html::tag('tr', $showTd);

foreach($bag as $item)
{
    $showTd = Html::tag('td', $item['item']['name']);
    $showTd .= Html::tag('td', $item['amount']);
    if($item['item']['type_id'] == 3)
    {
        $showTd .= Html::tag('td',
            Html::button('Продать 1 шт. (Цена: ' . $item['item']['piece'] . ')', ['class' => 'btn btn-warning',
                'id' => $item['item']['id'],
                'name' => 'sellItem'])
        );
    } else {
        $showTd .= Html::tag('td', 'Нельзя продать');
    }
    $showTR .= Html::tag('tr', $showTd);
}
$showTable = Html::tag('table', $showTR, ['class' => 'table table-bordered']);

$show .= $showTable;

$optButGame = ['class' => ['btn', 'btn-success'],
    'name' => 'startGame'];
foreach($game_all as $game)
{
    $optButGame['id'] = $game->id;
    $show .= Html::button($game->name . ' (Цена: ' . $game->type->name . ' - ' . $game->piece . ') ', $optButGame);
}

$message = "";
$op_div = array('id' => 'info', 'role' => 'alert');

if(Yii::$app->session->hasFlash('info'))
{
    $message = Yii::$app->session->getFlash('info');
    $op_div['class'] = 'alert alert-info';
} else if (Yii::$app->session->hasFlash('good'))
{
    $message = Yii::$app->session->getFlash('good');
    $op_div['class'] = 'alert alert-success';
} else if (Yii::$app->session->hasFlash('bad'))
{
    $message = Yii::$app->session->getFlash('bad');
    $op_div['class'] = 'alert alert-danger';
}

$show .= Html::tag('div', $message, $op_div);

echo $show;
?>