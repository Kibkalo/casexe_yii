<?php
/**
 * Created by PhpStorm.
 * User: Френки
 * Date: 12.01.19
 * Time: 18:22
 */

namespace app\models\dbm;


use yii\db\ActiveRecord;

class ItemAmount extends ActiveRecord
{
    public static function tableName()
    {
        return 'sys_item_amount';
    }

    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }

} 