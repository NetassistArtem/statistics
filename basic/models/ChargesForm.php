<?php


namespace app\models;


use yii\base\Model;

class ChargesForm extends  Model
{
    public $year_from;
    public $year_to;
    public $users_type;


    /**
     * @return array the validation rules.
     */



    public function rules()
    {
        return [
            //  required
            [['year_from', 'year_to', 'users_type'], 'required'],

        ];
    }

}