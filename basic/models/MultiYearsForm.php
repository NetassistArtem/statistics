<?php


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