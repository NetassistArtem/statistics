<?php
namespace app\controllers;

use yii\base\Exception;
use yii\BaseYii;
use yii\debug\DebugAsset;
use yii\web\Controller;
use yii\web\UrlManager;

use app\models\SwitchdownIsinga;
use app\models\SwitchdownBilling;
use app\models\SwitchdownHistory;
use app\models\SwitchdownYearMonthForm;
use Yii;
use app;
use yii\web\Request;
use app\components\debugger\Debugger;
use yii\data\Pagination;


class SwitchdownController extends Controller

{
    public $data_convert;


    private function dataFilter($data, $data_billing)
    {
        $data_billing_2 = array();
        foreach ($data_billing as $key => $value) {
            $data_billing_2[$value['sw_name']] = $value;
        }
        $date_now = Yii::$app->formatter->asTimestamp('now');
        //$date_now = Yii::$app->formatter->asTimestamp('2017-10-13 19:38:46');
        // $data_t = Yii::$app->formatter->asDatetime($date_now, 'yyyy-MM-dd HH:mm:ss');
        $data_interval = Yii::$app->params['switchdown_realtime_interval'];
        $time_limit = $date_now - $data_interval;

        $data_new = array();
        $data_old_status_check = array();
        foreach ($data as $k => $v) {
            $date_timestamp_last_check = Yii::$app->formatter->asTimestamp($v['last_check']);
            $date_start_status_down = Yii::$app->formatter->asTimestamp($v['start_time_down']);
            $v_new = $v;
            $v_new['time_in_down'] = $date_now - $date_start_status_down;
            $v_new['switch_model'] = isset($data_billing_2[$v['tehnical_name']]['sw_model']) ? $data_billing_2[$v['tehnical_name']]['sw_model'] : '';
            $v_new['switch_address'] = isset($data_billing_2[$v['tehnical_name']]['sw_addr']) ? $data_billing_2[$v['tehnical_name']]['sw_addr'] : '';
            $v_new['switch_id'] = isset($data_billing_2[$v['tehnical_name']]['sw_id']) ? $data_billing_2[$v['tehnical_name']]['sw_id'] : '';
            if ($date_timestamp_last_check >= $time_limit) {

                $data_new[] = $v_new;
            } else {
                $last_ping = Yii::$app->formatter->asTimestamp($v_new['last_check']);
                $v_new_2 = $v_new;
                $v_new_2['time_without_ping'] = $date_now - $last_ping;
                $data_old_status_check[] = $v_new_2;
            }
        }

        //Debugger::EhoBr($data_new);
        //Debugger::EhoBr($data_t);
        // Debugger::PrintR($data_new);
        // Debugger::PrintR($data_old_status_check);
        // Debugger::testDie();
        return $data_n = array('data_new' => $data_new, 'data_old_status_check' => $data_old_status_check);
    }

    private function dataFilter2($data, $data_billing)
    {
        $data_billing_2 = array();
        foreach ($data_billing as $key => $value) {
            $data_billing_2[$value['sw_name']] = $value;
        }
        $data_new = array();
        foreach ($data as $k => $v) {
            $data_new[$k]['billing_id'] = isset($data_billing_2[$v['display_name']]['sw_id']) ? $data_billing_2[$v['display_name']]['sw_id'] : '';
            $data_new[$k]['issinga_object_id'] = $v['object_id'];
            $data_new[$k]['state'] = $v['state'];
            $data_new[$k]['start_time'] = $v['start_time'];
            $data_new[$k]['end_time'] = $v['end_time'];
            $data_new[$k]['duration_sec'] = $v['duration_sec'];
            $data_new[$k]['ip_address'] = $v['ip_address'];
            $data_new[$k]['output'] = $v['output'];
        }

        return $data_new;
    }

    private function dataFilter3($data, $data_billing, $end_time, $filters)
    {
        //   Debugger::PrintR($data_billing);
        // Debugger::testDie();
        $data_billing_2 = array();
        foreach ($data_billing as $key => $value) {
            $data_billing_2[$value['sw_id']] = $value;
        }

        $time_filter_value = isset($filters['time'])  ?  $this->timeFilterToSecond($filters['time']['unit'], $filters['time']['value']) : 0;
//Debugger::Br();
//Debugger::VarDamp($time_filter_value);
     //   Debugger::testDie();
        $data_statistic = array();

        foreach ($data as $k => $v) {
            if ($v['duration_sec'] > $time_filter_value) {
                $billing_d = isset($data_billing_2[$v['billing_id']]) ? $data_billing_2[$v['billing_id']] : array();
                //Debugger::EhoBr($v['duration_sec']);

                if ($v['end_time'] > $end_time) {
                    $duration = $end_time - $v['start_time'];
                    $data[$k]['end_time'] = '';//$end_time;
                    $data[$k]['duration_sec'] = $duration;
                }
                $duration_total = isset($data_statistic[$v['issinga_object_id']]['duration_total']) ? $data_statistic[$v['issinga_object_id']]['duration_total'] : 0;
                $n_down = isset($data_statistic[$v['issinga_object_id']]['n_down']) ? $data_statistic[$v['issinga_object_id']]['n_down'] : 0;

                $data_statistic[$v['issinga_object_id']]['billing_id'] = $v['billing_id'];
                $data_statistic[$v['issinga_object_id']]['issinga_object_id'] = $v['issinga_object_id'];
                $data_statistic[$v['issinga_object_id']]['ip_address'] = $v['ip_address'];
                $data_statistic[$v['issinga_object_id']]['sw_name'] = isset($billing_d['sw_name']) ? $billing_d['sw_name'] : '';
                $data_statistic[$v['issinga_object_id']]['sw_addr'] = isset($billing_d['sw_addr']) ? $billing_d['sw_addr'] : '';
                $data_statistic[$v['issinga_object_id']]['sw_model'] = isset($billing_d['sw_model']) ? $billing_d['sw_model'] : '';
                $data_statistic[$v['issinga_object_id']]['start_time'][$v['id']] = Yii::$app->formatter->asDatetime($v['start_time'], 'Y-MM-dd HH:mm:ss');
                $data_statistic[$v['issinga_object_id']]['end_time'][$v['id']] = $data[$k]['end_time'] ? Yii::$app->formatter->asDatetime($data[$k]['end_time'], 'Y-MM-dd HH:mm:ss') : ' - ';
                $data_statistic[$v['issinga_object_id']]['duration_sec'][$v['id']] = $data[$k]['duration_sec'];
                $data_statistic[$v['issinga_object_id']]['output'][$v['id']] = $data[$k]['output'];
                $data_statistic[$v['issinga_object_id']]['duration_total'] = ($duration_total + $data[$k]['duration_sec']);
                $data_statistic[$v['issinga_object_id']]['n_down'] = ($n_down + 1);
            }

        }
        //   Debugger::PrintR($data_statistic);
        //  Debugger::testDie();
        return $data_statistic;

    }


    private function parsUrl()
    {
        $url__array_get = explode("?", Yii::$app->request->url);
        $url_array = explode("/", $url__array_get[0]);

        $param_array = $url_array[3] ? explode("-", $url_array[3]) : array();
        $n = count($param_array);
        switch ($n) {
            case 1:
                $time_start = $param_array[0] . '-01-01 00:00:00';
                $time_end = ($param_array[0] + 1) . '-01-01 00:00:00';
                break;
            case 2:
                $time_start = $param_array[0] . '-' . $param_array[1] . '-01 00:00:00';
                $time_end = $param_array[0] . '-' . ($param_array[1] + 1) . '-01 00:00:00';
                break;
            case 3:
                $time_start = $param_array[0] . '-' . $param_array[1] . '-' . $param_array[2] . ' 00:00:00';
                $time_end = $param_array[0] . '-' . $param_array[1] . '-' . ($param_array[2] + 1) . ' 00:00:00';
                break;
            default:
                $time_start = null;
                $time_end = null;
        }
        return $time = array(
            'start' => $time_start,
            'end' => $time_end,
        );
    }

    private function parsUrl2()
    {
        $url__array_get = explode("?", Yii::$app->request->url);
        $url_array = explode("/", $url__array_get[0]);

        $param_array = $url_array[3] ? explode("-", $url_array[3]) : array();
        $n = count($param_array);
        $time_start_1 = '';
        $time_end_1 = '';
        switch ($n) {
            case 1:
                $time_start = Yii::$app->formatter->asTimestamp($param_array[0] . '-01-01 00:00:00');//$param_array[0].'-01-01 00:00:00';
                $time_end = (Yii::$app->formatter->asTimestamp(($param_array[0] + 1) . '-01-01 00:00:00')) - 1;
                $year = $param_array[0];
                $month = '';
                $day = '';
                break;
            case 2:
                $time_start = Yii::$app->formatter->asTimestamp($param_array[0] . '-' . $param_array[1] . '-01 00:00:00');
                $time_end = (Yii::$app->formatter->asTimestamp($param_array[0] . '-' . ($param_array[1] + 1) . '-01 00:00:00')) - 1;
                $year = $param_array[0];
                $month = $param_array[1];
                $day = '';
                break;
            case 3:
                $time_start = Yii::$app->formatter->asTimestamp($param_array[0] . '-' . $param_array[1] . '-' . $param_array[2] . ' 00:00:00');
                $time_end = (Yii::$app->formatter->asTimestamp($param_array[0] . '-' . $param_array[1] . '-' . ($param_array[2] + 1) . ' 00:00:00')) - 1;
                $year = $param_array[0];
                $month = $param_array[1];
                $day = $param_array[2];
                break;
            case 8:
                $time_start_1 = $param_array[1] . '-' . $param_array[2] .'-'. $param_array[3];
                $time_end_1 = $param_array[5] . '-' . $param_array[6] .'-'. $param_array[7];
                $time_start = Yii::$app->formatter->asTimestamp($param_array[1] . '-' . $param_array[2] .'-'. $param_array[3].' 00:00:00');
                $time_end = (Yii::$app->formatter->asTimestamp($param_array[5] . '-' . $param_array[6] .'-'. $param_array[7] . ' 00:00:00')) - 1;
                $year = '';
                $month = '';
                $day = '';
                break;

            default:
                $time_start = null;
                $time_end = null;
                $year = '';
                $month = '';
                $day = '';
        }
        return $time = array(
            'start' => $time_start,
            'end' => $time_end,
            'start_1' => $time_start_1,
            'end_1' => $time_end_1,
            'period' => $param_array[0],
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'n' => $n,
        );

    }


    private function getMenuItemsYears()
    {
        $menu_years_item = array();
        $start_year = Yii::$app->params['switchdown_start_year'];
        for ($i = $start_year; $i <= Yii::$app->formatter->asDate('now', 'Y'); $i++) {
            $menu_years_item[] = ['label' => "$i", 'url' => "/switchdown/get-history/$i", "options" => ["id" => "$i"], 'active' => ("/switchdown/get-history/$i" == Yii::$app->request->url)];
        }

        return $menu_years_item;
    }

    private function getYearsArray()
    {
        $years_array = array();
        $start_year = Yii::$app->params['switchdown_start_year'];
        for ($i = $start_year; $i <= Yii::$app->formatter->asDate('now', 'Y'); $i++) {
            $years_array[$i] = $i;
        }
        return $years_array;
    }

    private function getMonthsArray()
    {
        $months_array = array(
            '01' => 'январь',
            '02' => 'февраль',
            '03' => 'март',
            '04' => 'апрель',
            '05' => 'май',
            '06' => 'июнь',
            '07' => 'июль',
            '08' => 'август',
            '09' => 'сентябрь',
            '10' => 'октябрь',
            '11' => 'ноябрь',
            '12' => 'декабрь',
        );
        return $months_array;
    }

    private function getUnitsArray()
    {
        $units_array = array(
            1 => 'секунды',
            2 => 'минуты',
            3 => 'часы',
            4 => 'дни',
        );
        return $units_array;
    }

    private function timeFilterToSecond($unit, $value)
    {
        switch ($unit) {
            case 1:
                $v = $value;
                break;
            case 2:
                $v = $value * 60;
                break;
            case 3:
                $v = $value * 60 * 60;
                break;
            case 4:
                $v = $value * 60 * 60 * 24;
                break;
            default:
                $v = $value;
        }
        return $v;
    }


    private function getNoStartData($data)
    {
        $data_no_start_time = array();
        $data_with_start_time = array();
        foreach ($data as $k => $v) {
            if ($v['start_time'] == 0) {
                $data_no_start_time[$v['issinga_object_id']] = $v;

            } else {
                $data_with_start_time[$k] = $v;
            }
        }
        return array(
            'data_no_start_time' => $data_no_start_time,
            'data_with_start_time' => $data_with_start_time,
        );

    }

    public function actionRealtime()
    {

        $SwithdownIsingaModel = new SwitchdownIsinga;
        $data = $SwithdownIsingaModel->getRealtimeData();
        $SwithdownBillingModel = new SwitchdownBilling();
        $data_billing = $SwithdownBillingModel->getBillingData();

        //   Debugger::PrintR($data_billing);
        $data_new = $this->dataFilter($data, $data_billing);
        $data_now = $data_new['data_new'];

        $pages = new Pagination(['totalCount' => count($data_now), 'pageSize' => Yii::$app->params['switchdown_realtime_items_per_page']]);
        $pages->pageSizeParam = false;
        $data_now_page = array_slice($data_now, $pages->offset, $pages->limit, $preserve_keys = true);


        return $this->render('realtime', [
            'data_now' => $data_now_page,
            'pages' => $pages,
        ]);

    }


    public function actionRealtimeOld()
    {

        $SwitchdownIsingaModel = new SwitchdownIsinga;
        $data = $SwitchdownIsingaModel->getRealtimeData();
        $SwitchdownBillingModel = new SwitchdownBilling();
        $data_billing = $SwitchdownBillingModel->getBillingData();
        //  Debugger::PrintR($data);
        $data_new = $this->dataFilter($data, $data_billing);
        $data_old_status_check = $data_new['data_old_status_check'];

        $pages = new Pagination(['totalCount' => count($data_old_status_check), 'pageSize' => Yii::$app->params['switchdown_realtime_items_per_page']]);
        $pages->pageSizeParam = false;

        $data_old_status_check_page = array_slice($data_old_status_check, $pages->offset, $pages->limit, $preserve_keys = true);


        return $this->render('realtime-old', [
            'data_old_status_check' => $data_old_status_check_page,
            'pages' => $pages,

        ]);

    }

    public function actionGetLinkedSwitch()
    {
        $switch_id = Yii::$app->request->get('switch_id');
        if (!$switch_id) {
            return $this->renderPartial('get-no-switch-id');
        }

        $SwitchdownBillingModel = new SwitchdownBilling();
        $linked_switch = $SwitchdownBillingModel->getLinkedSwitch($switch_id);
        $not_linked_switch = empty($linked_switch) ? 1 : 0;


        return $this->renderPartial('get-linked-switch', [
            'linked_switch' => $linked_switch,
            'not_linked_switch' => $not_linked_switch,
        ]);
    }

    private function getStateChange($n_start, $value_array, $n_count)
    {
        for ($i = ($n_start + 1); $i <= $n_count; $i++) {
            //  Debugger::Eho($i);
            //  Debugger::testDie();
            if (isset($value_array[$n_start]) && isset($value_array[$i])) {
                if ($value_array[$n_start]['state'] != $value_array[$i]['state']) {
                    return $i;
                }
            } else return false;

        }
        return false;
    }

    private function recursive_data_intervals($n_start, $key, $value_array, $n_count, $start_time_period, $end_time_period)
    {
        $n_next = $this->getStateChange($n_start, $value_array, $n_count);

        if ($value_array[$n_start]['state'] == 1) {

            $timestamp_start = Yii::$app->formatter->asTimestamp($value_array[$n_start]['state_time']);
            $end_time = $n_next ? $value_array[$n_next]['state_time'] : '';
            $end_time_colculate = $end_time ? $end_time : $end_time_period;
            $timestamp_end = Yii::$app->formatter->asTimestamp($end_time_colculate);
            $this->data_convert[$key . "_" . $n_start] = array(
                'object_id' => $key,
                'state' => $value_array[$n_start]['state'],
                'start_time' => $timestamp_start,
                'end_time' => Yii::$app->formatter->asTimestamp($end_time),
                'output' => $value_array[$n_start]['output'],
                'display_name' => $value_array[$n_start]['display_name'],
                'ip_address' => $value_array[$n_start]['ip_address'],
                'duration_sec' => ($timestamp_end - $timestamp_start),
            );

        } else {
            $timestamp_start = Yii::$app->formatter->asTimestamp($start_time_period);
            $timestamp_end = Yii::$app->formatter->asTimestamp($value_array[$n_start]['state_time']);

            $this->data_convert[$key . "_" . $n_start] = array(
                'object_id' => $key,
                'state' => $value_array[$n_start]['state'],
                'start_time' => '',
                'end_time' => $timestamp_end,
                'output' => $value_array[$n_start]['output'],
                'display_name' => $value_array[$n_start]['display_name'],
                'ip_address' => $value_array[$n_start]['ip_address'],
                'duration_sec' => ($timestamp_end - $timestamp_start),
            );
        }

        //  Debugger::Eho('tr ');

        $n_next_next = $n_next ? ($n_next + 1) : '';
        //  Debugger::Eho($n_next .' test');
        //  Debugger::Eho('</br>');
        //  Debugger::VarDamp(isset($value_array[$n_next_next]));


        if (isset($value_array[$n_next_next])) {
            //  Debugger::Eho($n_next_next);
            //   Debugger::PrintR($value_array[$n_next_next]);
            //    Debugger::Eho($n_count);
            // Debugger::Eho('</br>');
            //   Debugger::Eho($key);
            // Debugger::PrintR($value_array);


            // Debugger::testDie();
            //  $test_array = array();
            $this->recursive_data_intervals($n_next_next, $key, $value_array, $n_count, $start_time_period, $end_time_period);

        }
        // Debugger::PrintR($data_down_intervals);
        // Debugger::testDie();
        //    return $data_down_intervals;

    }

    private function parseHistoryData($data, $start_time, $end_time)
    {
        $data_new = array();
        foreach ($data as $k => $v) {
            $data_new[$v['object_id']][] = $v;
        }

        //    $data_new_2[3760] =   $data_new[3760];

        //  Debugger::Eho('</br>');
        //  Debugger::Eho('</br>');
        //  Debugger::Eho('</br>');
        //  Debugger::Eho('</br>');
        //  Debugger::Eho('</br>');
        //  Debugger::PrintR($data_new_2);
        //  Debugger::testDie();

        $data_down_intervals = array();
        foreach ($data_new as $key => $value) {
            $n = count($value);
            //   Debugger::Eho($n);
            //  Debugger::Eho("</br>");
            if ($n == 1) {
                if ($value[0]['state'] == 1) {
                    $timestamp_start = Yii::$app->formatter->asTimestamp($value[0]['state_time']);
                    $timestamp_end = Yii::$app->formatter->asTimestamp($end_time);
                    $this->data_convert[$key . "_0"] = array(
                        'object_id' => $key,
                        'state' => $value[0]['state'],
                        'start_time' => $timestamp_start,
                        'end_time' => '',
                        'output' => $value[0]['output'],
                        'display_name' => $value[0]['display_name'],
                        'ip_address' => $value[0]['ip_address'],
                        'duration_sec' => ($timestamp_end - $timestamp_start),

                    );
                } else {
                    $timestamp_start = Yii::$app->formatter->asTimestamp($start_time);
                    $timestamp_end = Yii::$app->formatter->asTimestamp($value[0]['state_time']);
                    $this->data_convert[$key . "_0"] = array(
                        'object_id' => $key,
                        'state' => $value[0]['state'],
                        'start_time' => '',
                        'end_time' => $timestamp_end,
                        'output' => $value[0]['output'],
                        'display_name' => $value[0]['display_name'],
                        'ip_address' => $value[0]['ip_address'],
                        'duration_sec' => ($timestamp_end - $timestamp_start),

                    );

                }

            } else {


                /*    $data_down_intervals[] = */
                $this->recursive_data_intervals(0, $key, $value, $n, $start_time, $end_time);

                // $k_n = 0;
                /*    $n_next = $this->getStateChange(0,$value, $n);
                    Debugger::Eho($n_next .' test');
                    Debugger::Eho("</br>");

                            $data_down_intervals[] = array(
                                'object_id' => $key,
                                'state' => $value[0]['state'],
                                'start_time' => $value[0]['state_time'],
                                'end_time' => isset($n_next) ? $n_next : '' ,//isset($n_next) ?  $value[$n_next]['state_time'] :'',
                                'output' => $value[0]['output'],
                                'display_name' => $value[0]['display_name'],
                                'ip_address' => $value[0]['ip_address'],
                            ); */


            }


        }
        //  Debugger::PrintR($data_down_intervals);

        //  Debugger::PrintR($this->data_convert);
        //  Debugger::Eho(count($this->data_convert));
        //  Debugger::testDie();
    }


    public function actionGetHistoryDay()
    {


        $modelSwitchdownYearMonthForm = new SwitchdownYearMonthForm();
        if (Yii::$app->request->post()) {
            $year_post = isset(Yii::$app->request->post('SwitchdownYearMonthForm')['year']) ? Yii::$app->request->post('SwitchdownYearMonthForm')['year'] : '';
            $month_post = isset(Yii::$app->request->post('SwitchdownYearMonthForm')['month']) ? Yii::$app->request->post('SwitchdownYearMonthForm')['month'] : '';
            $day_post = isset(Yii::$app->request->post('SwitchdownYearMonthForm')['day']) ? Yii::$app->request->post('SwitchdownYearMonthForm')['day'] : '';
            $unit_post = isset(Yii::$app->request->post('SwitchdownYearMonthForm')['unit']) ? Yii::$app->request->post('SwitchdownYearMonthForm')['unit'] : '';
            $time_post = isset(Yii::$app->request->post('SwitchdownYearMonthForm')['time']) ? Yii::$app->request->post('SwitchdownYearMonthForm')['time'] : '';
            $date_from_post = isset(Yii::$app->request->post('SwitchdownYearMonthForm')['date_from']) ? Yii::$app->request->post('SwitchdownYearMonthForm')['date_from'] : '';
            $date_to_post = isset(Yii::$app->request->post('SwitchdownYearMonthForm')['date_to']) ? Yii::$app->request->post('SwitchdownYearMonthForm')['date_to'] : '';

            if ($year_post || $day_post || ($date_from_post && $date_to_post)) {
                //  Debugger::EhoBr($modelSwitchdownYearMonthForm->year);
                //  Debugger::testDie();
                if($date_from_post && $date_to_post){
                    $date = 'from-'.$date_from_post.'-to-'.$date_to_post;
                }else{
                    $date = $year_post . ($month_post ? '-' : '') . $month_post . ($day_post ? '-' : '') . $day_post . '?' . ($unit_post ? "unit=$unit_post" : '') . ($time_post ? "&time=$time_post" : '');
                }
                $this->redirect('/switchdown/get-history/' . $date);
            }
        }

        //  $this->writeNewData(); //запустить когда все будет готово на продакшине
        $time = $this->parsUrl2();


        if (!$time['start']) {
            return $this->redirect('/switchdown/no-data-switchdown');
        }
        if (Yii::$app->request->get('unit') && Yii::$app->request->get('time')) {
            $filters_post = array(
                'time' => array(
                    'value' => Yii::$app->request->get('time'),
                    'unit' => Yii::$app->request->get('unit'),
                )
            );
        }




        $filters = !empty($filters_post) ? $filters_post : array();
        $SwitchdownHistoryModel = new SwitchdownHistory;
        $data = $SwitchdownHistoryModel->getDataFromInterval($time['start'], $time['end']);
        $SwitchdownBillingModel = new SwitchdownBilling();
        $data_billing = $SwitchdownBillingModel->getBillingData();
        $data_new = $this->dataFilter3($data, $data_billing, $time['end'], $filters);

        $pages = new Pagination(['totalCount' => count($data_new), 'pageSize' => Yii::$app->params['switchdown_history_items_per_page']]);
        $pages->pageSizeParam = false;


        $data_new_page = array_slice($data_new, $pages->offset, $pages->limit, $preserve_keys = true);


        return $this->render('get-history-day', [
            'data' => $data_new_page,
            'pages' => $pages,
            'period' => $time['period'],
            'year' => $time['year'],
            'month' => $time['month'],
            'day' => $time['day'],
            'date_1' => $time['year'].'-'.$time['month'].'-'.$time['day'],
            'date_from_1' =>$time['start_1'],
            'date_to_1' =>$time['end_1'],
            'menu_years_item' => $this->getMenuItemsYears(),
            'n_date' => $time['n'],
            'year_now' => Yii::$app->formatter->asDate('now', 'Y'),
            'year_month_now' => Yii::$app->formatter->asDate('now', 'Y-MM'),
            'year_month_day_now' => Yii::$app->formatter->asDate('now', 'Y-MM-dd'),
            'year_month_day_period_start' => Yii::$app->formatter->asDate((time() -172800), 'Y-MM-dd'),
            'modelSwitchdownYearMonthForm' => $modelSwitchdownYearMonthForm,
            'years_array' => $this->getYearsArray(),
            'months_array' => $this->getMonthsArray(),
            'units_array' => $this->getUnitsArray(),
            'time_post' => isset($filters_post['time'])  ? $filters_post['time']['value'] : '',
            'unit_post' => isset($filters_post['time'])  ? $filters_post['time']['unit'] : '',


        ]);
    }

    public function writeNewData()
    {
        $SwitchdownHistoryModel = new SwitchdownHistory;

        $time_now = Yii::$app->formatter->asTimestamp('now');
        $time_interval_setting = Yii::$app->params['switchdown_write_interval'];
        $last_time_write = $SwitchdownHistoryModel->getLastDataTime();
        $time_limit = Yii::$app->params['switchdown_write_time_limit'];
        $time_interval = $time_now - $last_time_write;


        if ($time_interval > $time_interval_setting) {

            $start_time = Yii::$app->formatter->asDatetime($last_time_write, 'yyyy-MM-dd H:i:s');//'2017-10-01 00:00:00';
            $end_time = Yii::$app->formatter->asDatetime($time_now, 'yyyy-MM-dd H:i:s');//'2017-10-02 00:00:00';

            //  Debugger::Eho('</br>');
            //  Debugger::Eho('</br>');
            //  Debugger::Eho('</br>');
            //  Debugger::Eho('</br>');
            //  Debugger::Eho('</br>');
            //  Debugger::Eho($time_interval);
            //  Debugger::Eho($time_limit);
            if ($time_interval > $time_limit) {
                $start_time = Yii::$app->formatter->asDatetime(($time_now - $time_limit), 'yyyy-MM-dd H:i:s');

                //   Debugger::Eho($start_time);
            }
            //  Debugger::testDie();

            $SwitchdownIsingaModel = new SwitchdownIsinga;
            $data = $SwitchdownIsingaModel->historyData($start_time, $end_time);
            $this->parseHistoryData($data, $start_time, $end_time);

            $SwitchdownBillingModel = new SwitchdownBilling();
            $data_billing = $SwitchdownBillingModel->getBillingData();

            $data_2 = $this->dataFilter2($this->data_convert, $data_billing);
            // Debugger::EhoBr(count($data_2));


            $data_no_end_time = $SwitchdownHistoryModel->getNoEndData();//все данные из базы (база приложения) где нет времени окончания
            $data_no_end_time_2 = array();
            foreach ($data_no_end_time as $k => $v) {
                $data_no_end_time_2[$v['issinga_object_id']] = $v;
            }
            $data_3 = $this->getNoStartData($data_2);
            $data_no_start_time = $data_3['data_no_start_time'];// все данные полученные из базы иссинги где нет времени старта
            $data_with_start_time = $data_3['data_with_start_time'];// все данные из базы иссинги (за период) где есть дата старта
            //  Debugger::PrintR($data_no_end_time_2);
            //Debugger::testDie();
            //   Debugger::PrintR($data_no_start_time);
            $change_data_no_end_time = array();//данные без даты окончания которым находятся данные из базы исинги (за период) где нет даты начала
            foreach ($data_no_end_time_2 as $k => $v) {
                if (isset($data_no_start_time[$k])) {
                    $change_data_no_end_time[$k] = $v;
                    $change_data_no_end_time[$k]['end_time'] = $data_no_start_time[$k]['end_time'];
                    unset($data_no_start_time[$k]);
                }
            }

            // $SwitchdownHistoryModel ->getFirstTime();
            //  Debugger::PrintR($change_data_no_end_time);


            if (!empty($data_no_start_time)) { //после удаления из массива данных без времени старта (соответсвует данным без даты окончания)
                // остаються данные, то прописывается им время старта = саммая рання дата времени старта в таблице
                //  $st = $SwitchdownHistoryModel ->getFirstTime();
                //  $start_time = $st ? $st : (time() - Yii::$app->params['switchdown_write_time_limit']);
                $start_time = (time() - Yii::$app->params['switchdown_write_time_limit']);

                foreach ($data_no_start_time as $k => $v) {
                    $data_no_start_time[$k]['start_time'] = $start_time;
                }
            }
            $data_write = array_merge($data_with_start_time, $data_no_start_time);//объединение данных изначально с временем старта
            // и оставшихся данных (если остались) после добавления даты старта
            //   Debugger::PrintR($change_data_no_end_time);
            if (!empty($change_data_no_end_time)) {
                $SwitchdownHistoryModel->updateData($change_data_no_end_time);
            }
            // обновление строк где не было даты окончания, если
            // нашлось соответствующие данные с датой окончания

            // Debugger::PrintR($data_no_start_time);
            //  Debugger::PrintR($data_write);
            //Debugger::testDie();

            //  $SwitchdownHistoryModel = new SwitchdownHistory;
            $SwitchdownHistoryModel->insertNewData($data_write);
            //     Debugger::testDie();


        }


    }

}