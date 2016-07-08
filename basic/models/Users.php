<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property integer $switch_id
 * @property integer $switch_ip
 * @property string $mac
 * @property integer $port
 * @property string $manufacturer
 * @property string $switch_model
 * @property string $firmware
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'switch_id', 'switch_ip', 'mac', 'port'], 'integer'],
            [['switch_id', 'switch_ip', 'mac', 'port', 'manufacturer', 'switch_model', 'firmware'], 'required'],
            [['manufacturer', 'switch_model'], 'string', 'max' => 200],
            [['firmware'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'switch_id' => 'Switch ID',
            'switch_ip' => 'Switch Ip',
            'mac' => 'Mac',
            'port' => 'Port',
            'manufacturer' => 'Manufacturer',
            'switch_model' => 'Switch Model',
            'firmware' => 'Firmware',
        ];
    }
}
