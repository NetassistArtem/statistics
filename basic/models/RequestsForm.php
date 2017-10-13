<?php


namespace app\models;


use yii\base\Model;

class RequestsForm extends  Model
{
    public $year_from;
    public $year_to;
    public $requests_org;
    public $requests_type;



    /**
     * @return array the validation rules.
     */



    public function rules()
    {
        return [
            //  required
            [['year_from', 'year_to', 'requests_org', 'requests_type'], 'required'],

        ];
    }

}