<?php


namespace app\models;


use yii\base\Model;
use app\components\debugger\Debugger;
use Yii;
use yii\base\Exception;

class TodoTime extends Model
{


    public function TodoSelect($period_from, $period_to, $todo_type, $todo_status)
    {

        $todo_support_old_request = Yii::$app->params['todo_support_old_query_request'];
        $sql_type = null;
        $p_mid_e = null;


        $period_from = strlen($period_from) % 2 ? '0' . $period_from : $period_from;
        $period_to = strlen($period_to) % 2 ? '0' . $period_to : $period_to;

     //   $period_from = (int)$period_from <100 ? $period_from.'01': $period_from;
     //   $period_to = (int)$period_to <100 ? $period_to.'01' : $period_to;


        //Debugger::testDie();

        if ($todo_type == 3) {
            if (($period_from < $todo_support_old_request && $period_to <= $todo_support_old_request) || ($period_from == $todo_support_old_request)) {

                $sql_type = 1;

            } elseif ($period_from > $todo_support_old_request && $period_to > $todo_support_old_request) {
                $sql_type = 2;
            } elseif ($period_from <= $todo_support_old_request && $period_to > $todo_support_old_request) {

                $todo_support_old_request_end = $todo_support_old_request + 1;
                $sql_type = 3;
                $t_m_e = strlen($todo_support_old_request_end) > 1 ? strlen($todo_support_old_request_end) : 2;
                $e_m_e = 10 - $t_m_e;
                $p_mid_e = $todo_support_old_request_end * pow(10, $e_m_e);

            } else {
                $sql_type = 0;
            }
        }
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
        $todo_status_string = '';

        foreach($todo_status as $v){
            $todo_status_string .= $v.',';
        }

        $todo_status_string = trim($todo_status_string,',');
        $todo_time_limit = Yii::$app->params['todo_time_limit'];


        if ((!$sql_type) || ($sql_type && $sql_type == 1)) {

            $params = array(
                ':period_from' => $p_from,
                ':period_to' => $p_to,
                ':todo_type' => $todo_type,
                ':todo_time_limit' =>  $todo_time_limit
            );

            $data = Yii::$app->db->createCommand("select * from
(select tab1.ts,tab1.todo_id,tab2.subj,tab2.ref_net_id,tab2.todo_state,init_time, upd_time ,((round((upd_time-init_time)/1000000) )*744)as mon,
((round((upd_time-round(upd_time,-6))/10000)-round((init_time-round(init_time,-6))/10000))*24)as day,

(round((upd_time-round(upd_time,-4))/100)-round((init_time-round(init_time,-4))/100)) as hour,

((round((upd_time-init_time)/1000000) )*720)+((round((upd_time-round(upd_time,-6))/10000)-round((init_time-round(init_time,-6))/10000))*24)+(round((upd_time-round(upd_time,-4))/100)-round((init_time-round(init_time,-4))/100)) as sum_hour
from
(select todo_id,init_time, round(init_time/1000000)as ts from todo_list where init_time between :period_from and :period_to  and todo_type= :todo_type and ver=0) as tab1 inner join

(select todo_id,subj,ref_net_id,todo_state,upd_time from todo_list where init_time between :period_from and :period_to and todo_type = :todo_type and todo_state in ($todo_status_string) group by todo_id) as tab2 on (tab1.todo_id=tab2.todo_id))
as tab3 where sum_hour< :todo_time_limit")
                ->bindValues($params)
                ->queryAll();
           // ->rawSql;


         //   Debugger::Eho($data);
        } elseif ($sql_type && $sql_type == 2) {

            $params = array(
                ':period_from' => $p_from,
                ':period_to' => $p_to,
                ':todo_type' => $todo_type,
                ':todo_time_limit' =>  $todo_time_limit,
            );

            $data = Yii::$app->db->createCommand("select * from
(select tab1.ts,tab1.todo_id,tab2.subj,tab2.ref_net_id,tab2.todo_state,init_time, upd_time ,((round((upd_time-init_time)/1000000) )*744)as mon,
((round((upd_time-round(upd_time,-6))/10000)-round((init_time-round(init_time,-6))/10000))*24)as day,

(round((upd_time-round(upd_time,-4))/100)-round((init_time-round(init_time,-4))/100)) as hour,

((round((upd_time-init_time)/1000000) )*720)+((round((upd_time-round(upd_time,-6))/10000)-round((init_time-round(init_time,-6))/10000))*24)+(round((upd_time-round(upd_time,-4))/100)-round((init_time-round(init_time,-4))/100)) as sum_hour
from
(select todo_id,init_time, round(init_time/1000000)as ts from todo_list where init_time between :period_from and :period_to  and todo_type= :todo_type and ver=0 and exec_list like '%-17%' and ref_acc_id>0 and ref_net_id<>1000 and admin_id<>-1) as tab1 inner join

(select todo_id,subj,ref_net_id,todo_state,upd_time from todo_list where init_time between :period_from and :period_to and todo_type = :todo_type and todo_state in ($todo_status_string) and exec_list like '%-17%' and ref_acc_id>0 and ref_net_id<>1000 and admin_id<>-1 group by todo_id) as tab2 on (tab1.todo_id=tab2.todo_id))
as tab3 where sum_hour< :todo_time_limit")
                ->bindValues($params)
                ->queryAll();
        } elseif ($sql_type && $sql_type == 3) {

            // Debugger::Eho($p_mid_e);
            //Debugger::Eho('</br>');
            //  Debugger::Eho($p_to);
            $params = array(
                ':period_from' => $p_from,
                ':period_to' => $p_mid_e,
                ':todo_type' => $todo_type,
                ':todo_time_limit' =>  $todo_time_limit,
            );

            $data_1 = Yii::$app->db->createCommand("select * from
(select tab1.ts,tab1.todo_id,tab2.subj,tab2.ref_net_id,tab2.todo_state,init_time, upd_time ,((round((upd_time-init_time)/1000000) )*744)as mon,
((round((upd_time-round(upd_time,-6))/10000)-round((init_time-round(init_time,-6))/10000))*24)as day,

(round((upd_time-round(upd_time,-4))/100)-round((init_time-round(init_time,-4))/100)) as hour,

((round((upd_time-init_time)/1000000) )*720)+((round((upd_time-round(upd_time,-6))/10000)-round((init_time-round(init_time,-6))/10000))*24)+(round((upd_time-round(upd_time,-4))/100)-round((init_time-round(init_time,-4))/100)) as sum_hour
from
(select todo_id,init_time, round(init_time/1000000)as ts from todo_list where init_time between :period_from and :period_to  and todo_type= :todo_type and ver=0) as tab1 inner join

(select todo_id,subj,ref_net_id,todo_state,upd_time from todo_list where init_time between :period_from and :period_to and todo_type = :todo_type and todo_state in ($todo_status_string) group by todo_id) as tab2 on (tab1.todo_id=tab2.todo_id))
as tab3 where sum_hour< :todo_time_limit")
                ->bindValues($params)
                ->queryAll();
            //->rawSql;
            //  Debugger::Eho($data_1);
            //  Debugger::testDie();

            $params = array(
                ':period_from' => $p_mid_e,
                ':period_to' => $p_to,
                ':todo_type' => $todo_type,
                ':todo_time_limit' =>  $todo_time_limit,
            );
            $data_2 = Yii::$app->db->createCommand("select * from
(select tab1.ts,tab1.todo_id,tab2.subj,tab2.ref_net_id,tab2.todo_state,init_time, upd_time ,((round((upd_time-init_time)/1000000) )*744)as mon,
((round((upd_time-round(upd_time,-6))/10000)-round((init_time-round(init_time,-6))/10000))*24)as day,

(round((upd_time-round(upd_time,-4))/100)-round((init_time-round(init_time,-4))/100)) as hour,

((round((upd_time-init_time)/1000000) )*720)+((round((upd_time-round(upd_time,-6))/10000)-round((init_time-round(init_time,-6))/10000))*24)+(round((upd_time-round(upd_time,-4))/100)-round((init_time-round(init_time,-4))/100)) as sum_hour
from
(select todo_id,init_time, round(init_time/1000000)as ts from todo_list where init_time between :period_from and :period_to  and todo_type= :todo_type and ver=0 and exec_list like '%-17%' and ref_acc_id>0 and ref_net_id<>1000 and admin_id<>-1) as tab1 inner join

(select todo_id,subj,ref_net_id,todo_state,upd_time from todo_list where init_time between :period_from and :period_to and todo_type = :todo_type and todo_state in ($todo_status_string) and exec_list like '%-17%' and ref_acc_id>0 and ref_net_id<>1000 and admin_id<>-1 group by todo_id) as tab2 on (tab1.todo_id=tab2.todo_id))
as tab3 where sum_hour< :todo_time_limit")
                ->bindValues($params)
                ->queryAll();


            $data = array_merge($data_1, $data_2);
            // Debugger::PrintR($data_1);
            // Debugger::PrintR($data_2);

        } else {
            return null;
        }

        return $data;
    }

    public function attributeLabels()
    {
        return [
            'ts' => 'Время',
            'ref_net_id' => 'ID сети',
            'todo_id' => 'TODO id',
            'todo_state' => 'TODO статус',
            'subj' => 'Описание',
            'init_time' => 'Время создания',
            'upd_time' => 'Время обновления',
            'mon' => 'Месяцев',
            'day' => 'Дней',
            'hour' => 'Дней',
            'sum_hour' => 'Сумма часов',

        ];
    }

}