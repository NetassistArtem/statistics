<?php


namespace app\models;


use yii\base\Model;

class SwitchdownYearMonthForm extends  Model
{
    public $year;
    public $month;
    public $day;
    public $unit;
    public $time;
    public $date_from;
    public $date_to;


    /**
     * @return array the validation rules.
     */



    public function rules()
    {
        return [
            //  required
            [['year', 'month', 'day', 'date_from', 'date_to'], 'required'],
            [['time'],'number']

        ];
    }

}