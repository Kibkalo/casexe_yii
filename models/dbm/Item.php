<?php
/**
 * Created by PhpStorm.
 * User: Френки
 * Date: 12.01.19
 * Time: 15:21
 */

namespace app\models\dbm;


use yii\db\ActiveRecord;

class Item extends ActiveRecord
{
    public static function tableName()
    {
        return 'tbl_item';
    }

    public function getType()
    {
        return $this->hasOne(Type::className(), ['id' => 'type_id']);
    }
} 