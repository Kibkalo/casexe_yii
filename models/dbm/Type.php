<?php
/**
 * Created by PhpStorm.
 * User: Френки
 * Date: 12.01.19
 * Time: 12:53
 */

namespace app\models\dbm;


use yii\db\ActiveRecord;

class Type extends ActiveRecord {

    public static function tableName()
    {
        return "sys_type";
    }

} 