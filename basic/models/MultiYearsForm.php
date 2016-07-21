<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 19.07.16
 * Time: 12:54
 */

namespace app\models;

use yii\base\Model;


class MultiYearsForm extends  Model
{
    public $years = array();
    public $users_type;

    /**
     * @return array the validation rules.
     */
    public function rules()
{
    return [
        //  required
        [['years', 'users_type'], 'required'],
    ];
}

}