<?php


namespace app\models;

use yii\base\Model;


class RequestsMultiYearsForm extends  Model
{
    public $years = array();
    public $requests_org;
    public $requests_type;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            //  required
            [['years', 'requests_org','requests_type'], 'required'],
        ];
    }

}