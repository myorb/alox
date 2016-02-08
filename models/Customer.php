<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 08.02.16
 * Time: 02:31
 */
namespace app\models;

class Customer extends \yii\redis\ActiveRecord
{
    public function attributes()
    {
        return ['id', 'name', 'address', 'registration_date'];
    }
}