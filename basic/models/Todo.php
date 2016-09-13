<?php


namespace app\models;

use app\components\debugger\Debugger;
use Yii;
use yii\base\Exception;
use yii\base\Model;


class Todo extends Model
{
    private function TodoDisconnectionSelect($period_from, $period_to, $todo_location)
    {
        $period_f = $period_from * pow(10, 2);
        $period_t = $period_to * pow(10, 2);

        $date_now = Yii::$app->formatter->asDate('now', 'yy');

        $date_now_with_month = ((int)$date_now + 1) * 10000000000;

        $todo_loc =  $todo_location ? $todo_location : ' and net_id<201 ';

        $params = array(
            ':period_from' => $period_f,
            ':period_to' => $period_t,
            ':time_limit' => $date_now_with_month
        );

        $data = Yii::$app->db->createCommand("select last, user_list.acc_id, user_name,user_list.net_id,user_addr,
 del_mark  from user_list inner join (select round(last_t/1000000) as last,acc_id,net_id from (select  max(ptime_stamp2)
  as last_t, acc_id,net_id,enable  from svc_log where ptime_stamp2 between :period_from and :time_limit and enable=0
  and acc_id not in ( select DISTINCT(acc_id) from svc_log where enable in (1,-2)) $todo_loc group by acc_id
   order by last_t desc) as tab where tab.last_t between 70100000000 and :period_to) as tab on
    (user_list.acc_id=tab.acc_id) where 1 group by  acc_id order by last")
            ->bindValues($params)
            ->queryAll();
        // ->rawSql;
        //Debugger::Eho($data);
        //Debugger::testDie();

        return $data;
    }

    public function TodoSelect($period_from, $period_to, $todo_type, $todo_location = null)
    {

        $todo_support_old_request = Yii::$app->params['todo_support_old_query_request'];
        $sql_type = null;
        $p_mid_e = null;


        $period_from = strlen($period_from) % 2 ? '0' . $period_from : $period_from;
        $period_to = strlen($period_to) % 2 ? '0' . $period_to : $period_to;

        $period_from = (int)$period_from <100 ? $period_from.'01': $period_from;
        $period_to = (int)$period_to <100 ? $period_to.'01' : $period_to;


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
        } elseif ($todo_type == 100) {
            $sql_type = 4;
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


        if($todo_location){
            if($todo_type == 100){
                $todo_loc = 'and net_id=' . $todo_location;
            }else{
                $todo_loc = 'and ref_net_id=' . $todo_location;
            }

        }else{
            $todo_loc = '';
        }

        if ((!$sql_type) || ($sql_type && $sql_type == 1)) {

            $params = array(
                ':period_from' => $p_from,
                ':period_to' => $p_to,
                ':todo_type' => $todo_type,
            );

            $data = Yii::$app->db->createCommand("select todo_id,init_time, subj,ref_net_id,todo_state from todo_list
 where init_time between :period_from and :period_to and back_ver=0 and todo_type= :todo_type $todo_loc  ORDER BY init_time")
                ->bindValues($params)
                ->queryAll();
        } elseif ($sql_type && $sql_type == 2) {

            $params = array(
                ':period_from' => $p_from,
                ':period_to' => $p_to,
            );

            $data = Yii::$app->db->createCommand("select todo_id,init_time, subj,ref_net_id,todo_state from todo_list
         where ver=0 and  init_time between :period_from and :period_to and exec_list like '%-17%' and ref_acc_id>0 and
         ref_net_id<>1000 and admin_id<>-1 $todo_loc ORDER BY init_time")
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
            );

            $data_1 = Yii::$app->db->createCommand("select todo_id,init_time, subj,ref_net_id,todo_state from todo_list
 where init_time between :period_from and :period_to and back_ver=0 and todo_type= :todo_type $todo_loc ORDER BY init_time")
                ->bindValues($params)
                ->queryAll();
               //->rawSql;
          //  Debugger::Eho($data_1);
          //  Debugger::testDie();

            $params = array(
                ':period_from' => $p_mid_e,
                ':period_to' => $p_to,
            );
            $data_2 = Yii::$app->db->createCommand("select todo_id,init_time, subj,ref_net_id,todo_state from todo_list
         where ver=0 and  init_time between :period_from and :period_to and exec_list like '%-17%' and ref_acc_id>0 and
         ref_net_id<>1000 and admin_id<>-1 $todo_loc ORDER BY init_time")
                ->bindValues($params)
                ->queryAll();


            $data = array_merge($data_1, $data_2);
           // Debugger::PrintR($data_1);
           // Debugger::PrintR($data_2);

        } elseif ($sql_type && $sql_type == 4) {
            return $this->TodoDisconnectionSelect($p_from, $p_to, $todo_loc);
        } else {
            return null;
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

    public function attributeLabelsDisconnection()
    {
        return [
            'last' => 'Время создания',
            'acc_id' => 'ID аккаунта',
            'user_name' => 'Имя пользователя',
            'net_id' => 'ID сети',
            'user_addr' => 'Адрес пользователя',
            'del_mark' => 'Удален полностью или временно'
        ];
    }

}