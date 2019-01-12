<?php
/**
 * Created by PhpStorm.
 * User: Френки
 * Date: 12.01.19
 * Time: 12:51
 */

namespace app\models\dbm;

use yii\db\ActiveRecord;

class Game extends ActiveRecord{

    public static function tableName()
    {
        return 'tbl_game';
    }

    public function getType()
    {
        return $this->hasOne(Type::className(), ['id' => 'type_id']);
    }
} 