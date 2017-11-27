<?php
namespace app\models;

use app\components\debugger\Debugger;
use Yii;
use yii\base\Exception;
use yii\base\Model;


class SwitchdownBilling extends Model
{
    //  public function getDb() {
    //      return Yii::$app->db2;
    //  }


    public function getBillingData()
    {
        $params = array();
        $data_billing = Yii::$app->db3->createCommand("SELECT  `sw_id` ,  `sw_name` ,  `sw_addr` ,  `sw_model`
FROM  `sw_list`")
            ->bindValues($params)
            ->queryAll();

        return $data_billing;

    }
     public function getLinkedSwitch($switch_id)
     {
         $params = array(
             ':switch_id' => $switch_id,
         );
         $linked_switch = Yii::$app->db3->createCommand("SELECT `ref_sw_id` FROM `port_list` WHERE `sw_id`= :switch_id AND `ref_sw_id`>0")
             ->bindValues($params)
             ->queryAll();


         return $linked_switch;
     }

}