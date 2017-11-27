<?php
namespace app\models;

use app\components\debugger\Debugger;
use Yii;
use yii\base\Exception;
use yii\base\Model;


class SwitchdownIsinga extends Model
{
  //  public function getDb() {
  //      return Yii::$app->db2;
  //  }

    public function getRealtimeData()
    {
        $params = array();

        $data = Yii::$app->db2->createCommand("SELECT st.host_object_id AS  'switch_id', st.last_time_up AS  'start_time_down', st.last_check, h.display_name AS  'tehnical_name', h.address AS  'ip_address'
FROM  `icinga_hoststatus` st
LEFT JOIN  `icinga_hosts` h ON st.host_object_id = h.host_object_id
WHERE st.current_state
IN ( 1, 2 )")
            ->bindValues($params)
            ->queryAll();
         //->rawSql;
         //Debugger::Eho($data);
     //    Debugger::PrintR($data);
        //  Debugger::Eho(microtime(true) - $GLOBALS['start_time']);
       //   Debugger::testDie();

      /**  Yii::$app->db3->createCommand("CREATE TEMPORARY TABLE t1 (
          switch_name VARCHAR (200) NOT NULL);")
            ->execute();

       // Debugger::PrintR($data);
       // Debugger::testDie();
        foreach($data as $k=>$v){
            $switch_name = $v['tehnical_name'];
            Yii::$app->db3->createCommand("INSERT INTO t1 VALUES ('$switch_name')")
                ->execute();
        }

        $data_2 = Yii::$app->db3->createCommand(" SELECT * FROM t1;")
            ->bindValues($params)
            ->queryAll();

Debugger::PrintR($data_2);
        Debugger::testDie();

**/

        return $data;

    }

    public function historyData($date_from, $date_to)
    {
        $params = array(
            ':date_from' => $date_from,
            ':date_to' => $date_to
        );

        $data = Yii::$app->db2->createCommand("SELECT
s.state_time, s.object_id, s.state, s.state_type, s.last_state, s.last_hard_state, s.output, h.display_name, h.address as ip_address
FROM icinga_statehistory s
RIGHT JOIN icinga_hosts h ON h.host_object_id = s.object_id
WHERE  s.state_time
BETWEEN  :date_from
AND  :date_to
ORDER BY s.state_time
")
            ->bindValues($params)
            ->queryAll();
        //->rawSql;
        //Debugger::Eho($data);
        //    Debugger::PrintR($data);

    //    s.state_type =1
      //  AND

        return $data;
    }


}