<?php
/**
 * Created by PhpStorm.
 * User: Френки
 * Date: 12.01.19
 * Time: 11:40
 */

namespace app\controllers;

use app\models\dbm\Game;
use app\models\dbm\GameDrop;
use app\models\dbm\Item;
use app\models\dbm\ItemAmount;
use app\models\dbm\UserItem;
use Project\Command\YourCustomCommand;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;

class GameController extends Controller {

    public function behaviors()
    {
        return ['access' => [
            'class' => AccessControl::className(),
            'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    // Колбек сработал! Эта страница может быть отображена только 31-ого октября
    public function actionSpecialCallback()
    {
        return $this->render('happy-halloween');
    }

    public function actionIndex()
    {
        $game_all = Game::find()->with('type')->all();
        $user_name = Yii::$app->user->identity->username;
        $user_id = Yii::$app->user->id;

        $bag = UserItem::find()->asArray()->with('item')->where(['user_id' => $user_id])->all();

        return $this->render('index', compact('game_all', 'user_name', 'bag'));
    }

    public function actionSell()
    {
        if(Yii::$app->request->isAjax)
        {
            $item_id = Yii::$app->request->post('id');
            $user_id = Yii::$app->user->id;

            $item = Item::findOne($item_id);
            $user_item = UserItem::findOne(['user_id' => $user_id, 'item_id' => $item_id]);
            $user_money = UserItem::findOne(['user_id' => $user_id, 'item_id' => 2]);

            $item_piece = $item->piece;

            if(count($user_money) > 0)
            {
                $user_money->amount = $user_money->amount + $item_piece;
                $user_money->save();
            } else {
                $user_money = new UserItem();
                $user_money->user_id = $user_id;
                $user_money->item_id = 2;
                $user_money->amount = $item_piece;
                $user_money->save();
            }

            $user_item->amount = $user_item->amount - 1;
            $user_item->save();

            if($user_item->amount == 0)
            {
                $user_item->delete();
            }

            $item_amount = ItemAmount::findOne(['item_id' => $item_id]);
            $item_amount->amount = $item_amount->amount + 1;
            $item_amount->save();

            Yii::$app->session->setFlash('good', "Продажа выполнена успешно");
        } else {
            Yii::$app->session->setFlash('bad', 'Неудачная продажа');
        }
        return 0;
    }

    public function actionPlay()
    {
        if(Yii::$app->request->isAjax)
        {
            $id = Yii::$app->request->post('id');
            $user_id = Yii::$app->user->id;

            $game = Game::findOne($id);
            $item = Item::findOne(['type_id' => $game->type_id]);

            $item_piece_id = $item->id;
            $game_piece = $game->piece;

            $user_piece = UserItem::findOne(['user_id' => $user_id,
                'item_id' => $item_piece_id]);

            if($user_piece->amount >= $game_piece)
            {
                $user_piece->amount = $user_piece->amount - $game_piece;
                $user_piece->save();
            } else {
                Yii::$app->session->setFlash('info', 'Недостаточно Бонусов!!');
                return 0;
            }

            $game_drop = GameDrop::find()
                ->leftJoin('sys_item_amount', 'sys_item_amount.item_id = tbl_game_drop.item_id')
                ->where(['tbl_game_drop.game_id' => 1])
                ->andWhere(['>=', 'sys_item_amount.amount', 0])
                ->all();
            $rand = rand(0, count($game_drop));

            $item_id = $game_drop[$rand]->item_id;
            $item_name = $game_drop[$rand]->item->name;
            $count = rand($game_drop[$rand]->min, $game_drop[$rand]->max);

            $bag = UserItem::findOne(['user_id' => $user_id,
                'item_id' => $item_id]);

            if(count($bag) > 0)
            {
                $bag->amount = $bag->amount + $count;
                $bag->save();
            } else {
                $bag = new UserItem();
                $bag->user_id = $user_id;
                $bag->item_id = $item_id;
                $bag->amount = $count;
                $bag->save();
            }

            $item_amount = ItemAmount::findOne(['item_id' => $item_id]);
            $item_amount->amount = $bag->amount + $count;
            $item_amount->save();

            Yii::$app->session->setFlash('good', "Получено $item_name $count шт.");
        } else {
            Yii::$app->session->setFlash('bad', 'Неудачная игра');
        }
        return 0;
    }
} 