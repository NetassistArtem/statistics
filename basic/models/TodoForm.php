<?php


namespace app\models;


use yii\base\Model;

class TodoForm extends  Model
{
    public $year_from;
    public $year_to;
    public $todo_type;
    public $todo_status;
    public $todo_location;


    /**
     * @return array the validation rules.
     */



    public function rules()
    {
        return [
            //  required
            [['year_from', 'year_to', 'todo_type', 'todo_status','todo_location'], 'required'],

        ];
    }

}