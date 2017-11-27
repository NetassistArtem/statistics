<?php
namespace app\models;

use app\components\debugger\Debugger;
use Yii;
use yii\base\Exception;
use yii\base\Model;


class SwitchdownHistory extends Model
{
    //  public function getDb() {
    //      return Yii::$app->db2;
    //  }

    public function insertNewData($data)
    {
        $params = array();


        $time_now = Yii::$app->formatter->asTimestamp('now');
    //    $test = Yii::$app->formatter->asDatetime($time_now,  'yyyy-MM-dd H:i:s');
      //  Debugger::Eho($test);
       // Debugger::testDie();



     $sql_comand = 'INSERT INTO `switch_down_history`(`billing_id`, `issinga_object_id`, `state`, `start_time`, `end_time`, `duration_sec`, `ip_address` , `output`) VALUES ';
        foreach ($data as $k => $v){
            $sql_comand .= '(';
            $sql_comand .= "'".$v['billing_id']."',";
            $sql_comand .= "'".$v['issinga_object_id']."',";
            $sql_comand .= "'".$v['state']."',";
            $sql_comand .= "'".$v['start_time']."',";
            $sql_comand .= "'".$v['end_time']."',";
            $sql_comand .= "'".$v['duration_sec']."',";
            $sql_comand .= "'".$v['ip_address']."',";
            $sql_comand .= "'".$v['output']."'";
            $sql_comand .= '),';
        }
        $sql_comand =  substr($sql_comand, 0, -1);



        Yii::$app->db4->createCommand($sql_comand)
           // ->bindValues($params)
            ->execute();
        //->rawSql;
       // Debugger::Eho($data);
        //    Debugger::PrintR($data);
        //  Debugger::Eho(microtime(true) - $GLOBALS['start_time']);
         //  Debugger::testDie();
        $params = array(
            ':time' => $time_now,
        );

        Yii::$app->db4->createCommand("INSERT INTO `last_write`( `time`) VALUES (:time)")
            ->bindValues($params)
            ->execute();

        /**  Yii::$app->db3->createCommand("CREATE TEMPORARY TABLE t1 (
         * switch_name VARCHAR (200) NOT NULL);")
         * ->execute();
         *
         * // Debugger::PrintR($data);
         * // Debugger::testDie();
         * foreach($data as $k=>$v){
         * $switch_name = $v['tehnical_name'];
         * Yii::$app->db3->createCommand("INSERT INTO t1 VALUES ('$switch_name')")
         * ->execute();
         * }
         *
         * $data_2 = Yii::$app->db3->createCommand(" SELECT * FROM t1;")
         * ->bindValues($params)
         * ->queryAll();
         *
         * Debugger::PrintR($data_2);
         * Debugger::testDie();
         **/

      //  return $data;

    }
    public function updateData($data)
    {
        $sql_comand = 'UPDATE `switch_down_history` SET `end_time` = CASE ';
        foreach ($data as $k => $v){
            $sql_comand .= " WHEN  `issinga_object_id` = '".$v['issinga_object_id'] . "' THEN '".$v['end_time']."' ";

        }
        $sql_comand .= "ELSE `end_time`  END";
//Debugger::Eho($sql_comand);
  //      Debugger::testDie();
        Yii::$app->db4->createCommand($sql_comand)
            // ->bindValues($params)
            ->execute();
    }

    public function getLastDataTime()
    {
        $params = array();
       $data = Yii::$app->db4->createCommand("SELECT MAX(id) as id, time FROM `last_write` ")
            ->bindValues($params)
            ->queryAll();
        //->rawSql;
       // Debugger::Eho($data);
       // Debugger::PrintR($data);
        return $data[0]['time'];

    }
    public function getFirstTime()
    {
        $params = array();
        $data = Yii::$app->db4->createCommand("SELECT MIN(start_time) as st FROM `switch_down_history`")
            ->bindValues($params)
            ->queryAll();
        //->rawSql;
        // Debugger::Eho($data);
       //  Debugger::PrintR($data);
       // Debugger::testDie();
        return $data[0]['st'];

    }


    public function getNoEndData()
    {
        $params = array(
            ':end_time' => 0,
        );
        $data = Yii::$app->db4->createCommand("SELECT * FROM `switch_down_history` WHERE end_time = :end_time")
            ->bindValues($params)
            ->queryAll();
        //->rawSql;
        // Debugger::PrintR($data);
        //Debugger::testDie();
        // Debugger::PrintR($data);
        return $data;
    }

    public function getNoStartData()
    {
        $params = array(
            ':start_time' => 0,
        );
        $data = Yii::$app->db4->createCommand("SELECT * FROM `switch_down_history` WHERE start_time = :start_time")
            ->bindValues($params)
            ->queryAll();
        //->rawSql;
       // Debugger::PrintR($data);
       // Debugger::testDie();
        // Debugger::PrintR($data);
        return $data;
    }
    public function getDataFromInterval($start_time, $end_time)
    {
        $params = array(
            ':start' => $start_time,
            ':end' => $end_time,
        );
        $data = Yii::$app->db4->createCommand("SELECT * FROM `switch_down_history` WHERE start_time  BETWEEN :start AND :end")
            ->bindValues($params)
            ->queryAll();
        return $data;
    }

}