<?php
/**
 * Created by PhpStorm.
 * User: Френки
 * Date: 12.01.19
 * Time: 17:09
 */

namespace app\models\dbm;


use yii\db\ActiveRecord;

class GameDrop extends ActiveRecord {

    public static function tableName()
    {
        return 'tbl_game_drop';
    }

    public function getType()
    {
        return $this->hasOne(Type::className(), ['id' => 'type_id']);
    }

    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }

} 