<?php
/**
 * Created by PhpStorm.
 * User: Френки
 * Date: 12.01.19
 * Time: 15:20
 */

namespace app\models\dbm;


use yii\db\ActiveRecord;

class UserItem extends ActiveRecord
{
    public static function tableName()
    {
        return 'tbl_user_item';
    }

    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }
} 