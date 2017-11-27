<?php


namespace app\models;

use app\components\debugger\Debugger;
use Yii;
use yii\base\Exception;
use yii\base\Model;


class Charges extends Model
{
    /**
     *
     *
     * параметр $scale  может иметь следующие значения
     * "100/100/100/10000" - выборка по годам
     * "100/100/10000" - выборка по месяцам
     * "100/10000" - выборка по дням
     *
     * параметр $period_from и $period_to
     * значения указывать следующим образом:
     * например 12  - означает 2012 год
     * например 1204  - означает 2012 год 04 месяц
     * например 120421 - означает 2012 год 04 месяц 21 число
     * например 12042117 - означает 2012 год 04 месяц 21 число 17:00:00
     * например 1204211735 - означает 2012 год 04 месяц 21 число 17:35:00
     *
     * параметр $net_id  и $user_class
     * $net_id_operator оператор  < , <=, =
     * net_id<101 user_class=0 - домашние абоненты без домосети
    net_id<=199 user_class=1 - бизнес абоненты домосети
    net_id=200 user_class=1 - бизнес абоненты без домосети

    net_id=203 user_class=1 - PI
     *
     * $user_class_unuse - если єтот параметр = о то используется sql запрос содержащий параметр user_class в запросе
     * если =1 , то user_class не используется в запросе
     *
     **/
    public function ChargesByNetwork($scale, $period_from,$period_to,$net_id_operator, $net_id, $user_class,$user_class_unuse = 0, $additional_condition = '')
    {
        /**
         * TODO
         * добавить проверку $scale $period_from,$period_to, $net_id, $user_class
         */

        $t = strlen($period_from)>1 ? strlen($period_from) : 2;
        $t_to = strlen($period_to)>1 ? strlen($period_to) : 2;
        $e_from = 12-$t;
        $p_from = $period_from *pow(10,$e_from);
        $e_to = 12-$t_to;
        $p_to = $period_to *pow(10,$e_to);
       // $p_from = 170000000000;
      //  Debugger::Eho($p_from);
       // Debugger::testDie();

        $params = array(
            ':period_from' => $p_from,
            ':period_to' => $p_to,
            ':net_id' => $net_id,
            ':user_class' => $user_class

        );


if($user_class_unuse == 0){
        $data = Yii::$app->db->createCommand("select round(pay_db.pay_stat.ptime_stamp/$scale) as ts, sum((pay_db.pay_stat.account_inc- pay_db.pay_stat.credit_inc) /1000) as pay
from pay_db.pay_stat inner join accounts where pay_db.pay_stat.acc_id=accounts.acc_id and
pay_db.pay_stat.ptime_stamp between :period_from and :period_to  and (accounts.net_id $net_id_operator :net_id $additional_condition)  and  account_inc-credit_inc>0 and pay_class<>0 and user_class= :user_class and accounts.org_id<>3 and net_id<>1 and accounts.acc_id not in (381,663,2177,2207 ) group by ts")
            ->bindValues($params)
            ->queryAll();
    //->rawSql;
//Debugger::Eho($data);
  //  Debugger::testDie();
//and accounts.acc_id not in (381,663,2177,2207 )

/**

    $data_2 = Yii::$app->db->createCommand("select round(pay_db.pay_stat.ptime_stamp/$scale) as ts, sum((pay_db.pay_stat.account_inc- pay_db.pay_stat.credit_inc) /1000) as pay
from pay_db.pay_stat inner join accounts where pay_db.pay_stat.acc_id=accounts.acc_id and
pay_db.pay_stat.ptime_stamp between :period_from and :period_to  and accounts.net_id $net_id_operator :net_id and  account_inc-credit_inc>0 and pay_class<>0 and user_class= :user_class and accounts.org_id<>3 and net_id<>1 group by ts")
        ->bindValues($params)
        ->rawSql;


    Debugger::Eho($data_2);
    Debugger::testDie();

**/

    }elseif($user_class_unuse ==1){
    $params = array(
        ':period_from' => $p_from,
        ':period_to' => $p_to,
        ':net_id' => $net_id
    );

    $data = Yii::$app->db->createCommand("select round(pay_db.pay_stat.ptime_stamp/$scale) as ts,sum((pay_db.pay_stat.account_inc- pay_db.pay_stat.credit_inc) /1000) as pay
from pay_db.pay_stat inner join accounts where pay_db.pay_stat.acc_id=accounts.acc_id and
pay_db.pay_stat.ptime_stamp between :period_from and :period_to  and (accounts.net_id $net_id_operator :net_id $additional_condition)  and  account_inc-credit_inc>0 and pay_class<>0  and accounts.org_id<>3 and net_id<>1 and accounts.acc_id not in (381,663,2177,2207 ) group by ts")
        ->bindValues($params)
        ->queryAll();


//Debugger::testDie();



/**
    $data_2 = Yii::$app->db->createCommand("select round(pay_db.pay_stat.ptime_stamp/$scale) as ts,sum((pay_db.pay_stat.account_inc- pay_db.pay_stat.credit_inc) /1000) as pay
from pay_db.pay_stat inner join accounts where pay_db.pay_stat.acc_id=accounts.acc_id and
pay_db.pay_stat.ptime_stamp between :period_from and :period_to  and accounts.net_id $net_id_operator :net_id and  account_inc-credit_inc>0 and pay_class<>0  and accounts.org_id<>3 and net_id<>1 group by ts")
        ->bindValues($params)
        ->rawSql;

    Debugger::Eho($data_2);
    Debugger::testDie();
**/

}else{
    throw new Exception('Не правильный параметр $user_class_unuse');
}


        return $data;
    }

    public function attributeLabels()
    {
        return [
            'ts' => 'Время',
            'pay' => 'Платежи',
        ];
    }







    public function ChargesByNetworkTest($scale, $period_from,$period_to,$net_id_operator, $net_id, $user_class,$user_class_unuse = 0, $net_id2, $net_id_operator2)
    {
        /**
         * TODO
         * добавить проверку $scale $period_from,$period_to, $net_id, $user_class
         */
        $t = strlen($period_from)>1 ? strlen($period_from) : 2;
        $t_to = strlen($period_to)>1 ? strlen($period_to) : 2;
        $e_from = 12-$t;
        $p_from = $period_from *pow(10,$e_from);
        $e_to = 12-$t_to;
        $p_to = $period_to *pow(10,$e_to);
       // $p_from = 170000000000;





//and accounts.acc_id not in (381,663,2177,2207 )

            /**

            $data_2 = Yii::$app->db->createCommand("select round(pay_db.pay_stat.ptime_stamp/$scale) as ts, sum((pay_db.pay_stat.account_inc- pay_db.pay_stat.credit_inc) /1000) as pay
            from pay_db.pay_stat inner join accounts where pay_db.pay_stat.acc_id=accounts.acc_id and
            pay_db.pay_stat.ptime_stamp between :period_from and :period_to  and accounts.net_id $net_id_operator :net_id and  account_inc-credit_inc>0 and pay_class<>0 and user_class= :user_class and accounts.org_id<>3 and net_id<>1 group by ts")
            ->bindValues($params)
            ->rawSql;


            Debugger::Eho($data_2);
            Debugger::testDie();

             **/



            $comand = '';
            $params = array(
                ':period_from' => $p_from,
                ':period_to' => $p_to,
            );

            foreach(Yii::$app->params['users_type'] as $k => $v){
                $name_teh = $v['name_teh'];
                $net_id_operator = $v['net_id_operator'];
                $params[':net_id_'.$name_teh] = $v['net_id'];
                $union = $k == 1 ? '' : 'union';
                $user_class = $v['user_class'] === (1 || 0) ? "and user_class= {$v['user_class']}":'';
                $comand .= " $union  select round(pay_db.pay_stat.ptime_stamp/$scale) as ts,sum((pay_db.pay_stat.account_inc- pay_db.pay_stat.credit_inc) /1000) as pay
from pay_db.pay_stat inner join accounts where pay_db.pay_stat.acc_id=accounts.acc_id and
pay_db.pay_stat.ptime_stamp between :period_from and :period_to  and accounts.net_id $net_id_operator :net_id_$name_teh and  account_inc-credit_inc>0 and pay_class<>0 $user_class  and accounts.org_id<>3 and net_id<>1 and accounts.acc_id not in (381,663,2177,2207 ) group by ts
";
            }








            $data = Yii::$app->db->createCommand(" $comand ")
                ->bindValues($params)
                ->queryAll();






            /**
            $data_2 = Yii::$app->db->createCommand("select round(pay_db.pay_stat.ptime_stamp/$scale) as ts,sum((pay_db.pay_stat.account_inc- pay_db.pay_stat.credit_inc) /1000) as pay
            from pay_db.pay_stat inner join accounts where pay_db.pay_stat.acc_id=accounts.acc_id and
            pay_db.pay_stat.ptime_stamp between :period_from and :period_to  and accounts.net_id $net_id_operator :net_id and  account_inc-credit_inc>0 and pay_class<>0  and accounts.org_id<>3 and net_id<>1 group by ts")
            ->bindValues($params)
            ->rawSql;

            Debugger::Eho($data_2);
            Debugger::testDie();
             **/




        return $data;
    }









}