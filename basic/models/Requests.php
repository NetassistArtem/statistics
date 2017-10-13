<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 06.09.17
 * Time: 11:32
 */

namespace app\models;


use yii\base\Model;
use app\components\debugger\Debugger;
use Yii;
use yii\base\Exception;

class Requests extends Model
{
    public function RequestsSelect($period_from, $period_to, array $billing_org_id)
    {

     //   $todo_support_old_request = Yii::$app->params['todo_support_old_query_request'];
     //   $sql_type = null;
     //   $p_mid_e = null;


        $period_from = strlen($period_from) % 2 ? '0' . $period_from : $period_from;
        $period_to = strlen($period_to) % 2 ? '0' . $period_to : $period_to;

        $period_from = (int)$period_from <100 ? $period_from.'01': $period_from;
        $period_to = (int)$period_to <100 ? $period_to.'01' : $period_to;


        //Debugger::testDie();


        //Debugger::Eho(strlen($period_from));
        $t = strlen($period_from) > 1 ? strlen($period_from) : 2;
        $t_to = strlen($period_to) > 1 ? strlen($period_to) : 2;
        $e_from = 10 - $t;
        $p_from = $period_from * pow(10, $e_from);
        $e_to = 10 - $t_to;
        $p_to = $period_to * pow(10, $e_to);
        //  Debugger::Eho($p_from);
        //  Debugger::Eho('</br>');
        //  Debugger::Eho($p_to);

        $params = array(
            ':period_from' => $p_from,
            ':period_to' => $p_to,
        );

if(!empty($billing_org_id)){

    $orgs_id = '';
    foreach($billing_org_id as $k=>$v){
        $orgs_id .= $v.',';
    }
    $orgs_id_str = trim($orgs_id,',');

    /*$data = Yii::$app->db->createCommand("SELECT itime_stamp as ts, req_list.req_id,
 info_src as info_n,todo_id,user_street,user_bnum, req_list.org_id, accounts.user_name,completed,req_list.user_comment
  FROM req_list left join accounts on (req_list.ref_acc_id=accounts.acc_id) WHERE  itime_stamp between :period_from and
   :period_to ORDER BY itime_stamp") */
    $data = Yii::$app->db->createCommand("select request_all.*, location_list.status from

(SELECT itime_stamp as ts, req_list.req_id, loc_id,info_src as info_n,todo_id,user_street,user_bnum,
req_list.org_id, accounts.user_name, accounts.user_class,round(month_pay_rate/1000) as tarif,completed,req_list.user_comment
 FROM req_list left join accounts on (req_list.ref_acc_id=accounts.acc_id) WHERE  itime_stamp
 between :period_from and :period_to and req_list.org_id in ($orgs_id_str) and completed<250 ORDER BY itime_stamp

) as request_all left join location_list on (request_all.loc_id=location_list.loc_id) ")

        ->bindValues($params)
        //->rawSql;
        ->queryAll();
//Debugger::Eho($data);
    //       Debugger::testDie();
}else{

    $data = Yii::$app->db->createCommand("select request_all.*, location_list.status from

(SELECT itime_stamp as ts, req_list.req_id, loc_id,info_src as info_n,todo_id,user_street,user_bnum,
req_list.org_id, accounts.user_name, accounts.user_class,round(month_pay_rate/1000) as tarif,completed,req_list.user_comment
 FROM req_list left join accounts on (req_list.ref_acc_id=accounts.acc_id) WHERE  itime_stamp
 between :period_from and :period_to  and completed<250 ORDER BY itime_stamp

) as request_all left join location_list on (request_all.loc_id=location_list.loc_id) ")

        ->bindValues($params)
        ->queryAll();
}


        return $data;
    }



    public function attributeLabels()
    {
        return [
            'init_time' => 'Время создания',
            'ref_net_id' => 'ID сети',
            'todo_id' => 'TODO id',
            'todo_state' => 'TODO статус',
            'subj' => 'Описание'
        ];
    }

}