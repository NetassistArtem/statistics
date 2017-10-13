<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 06.09.17
 * Time: 10:05
 */

namespace app\controllers;

use app\components\debugger\Debugger;
use app\models\Requests;
use app\models\RequestsForm;
use app\models\RequestsMultiYearsForm;
use yii\web\Controller;
use app;
use Yii;
use yii\base\Exception;


class RequestsController extends Controller
{
    private function chartCreater1($file_name, $chart_name, array $data_y, $data_x, $name_y, $name_x, $date_format, $max_YAxis, $text_angle_X, $series_name, $x_interval = 1)
    {
        include_once(__DIR__ . '/../vendor/pChart/pChart/pData.class');
        include_once(__DIR__ . '/../vendor/pChart/pChart/pChart.class');

        // Dataset definition
        $DataSet = new \pData;
        //  Debugger::Eho($date_format);
        // Debugger::testDie();

        $DataSet->SetXAxisFormat("date");
        $DataSet->AddPoint($data_x, "series_1x");

        $series_a = array();
        foreach ($data_y as $k => $v) {
            if($k != 'data_connect_all'){
                $DataSet->AddPoint($v, "series_$k");
                $DataSet->SetSerieName($series_name[$k], "series_$k");
                $series_a[] = "series_$k";
            }

        }

        $DataSet->AddAllSeries();
        $DataSet->RemoveSerie("series_1x");

        $DataSet->SetAbsciseLabelSerie("series_1x");
        //$DataSet->SetSerieName("January","Serie1");
        //$DataSet->SetSerieName("February","Serie2");
        $DataSet->SetYAxisName($name_y);
        $DataSet->SetXAxisName($name_x);

        // Initialise the graph
        $Test = new \pChart(1170, 545);
        //  $Test->setColorPalette(0, $color_pallet[0], $color_pallet[1], $color_pallet[2]);
        $requests_types_array = Yii::$app->params['requests_type'];
        //Debugger::PrintR($requests_types_array);
      //  Debugger::testDie();

        foreach ($requests_types_array as $k => $v) {
            if($k !=5){
                $Test->setColorPalette($k-1,$v['color'][0], $v['color'][1], $v['color'][2]);
            }


         }
        $Test->setFixedScale(0, $max_YAxis, 10);
        // Debugger::PrintR($series_a);
        // Debugger::Eho($max_YAxis);
        // Debugger::testDie();

        $Test->setDateFormat($date_format);
        //$Test->setFixedScale(0,4200,200);

        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 8);
        $Test->setGraphArea(70, 30, 1120, 450);
        $Test->drawFilledRoundedRectangle(7, 7, 1163, 538, 5, 240, 240, 240);
        $Test->drawRoundedRectangle(5, 5, 1165, 540, 5, 230, 230, 230);
        $Test->drawGraphArea(255, 255, 255, TRUE);
        $Test->drawScale($DataSet->GetData(), $DataSet->GetDataDescription(), SCALE_NORMAL, 0, 0, 0, TRUE, $text_angle_X, 0, TRUE, $x_interval);
        $Test->drawGrid(4, TRUE, 230, 230, 230, 50);

        // Draw the 0 line
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 6);
        $Test->drawTreshold(0, 143, 55, 72, TRUE, TRUE);

        // Draw the bar graph
        //  $Test->drawOverlayBarGraph($DataSet->GetData(), $DataSet->GetDataDescription());
        $Test->drawBarGraph($DataSet->GetData(), $DataSet->GetDataDescription(), TRUE);

        // Write values

        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 12);
        if (count($series_a) <= 4) {
            $Test->writeValues($DataSet->GetData(), $DataSet->GetDataDescription(), $series_a);
        }
        // Finish the graph
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 8);
        $Test->drawLegend(75, 35, $DataSet->GetDataDescription(), 255, 255, 255);
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 10);
        $Test->drawTitle(550, 22, $chart_name, 50, 50, 50, 585);
        $Test->Render(__DIR__ . '/../web/images/' . $file_name . '.png');

    }
//                   chartCreater2($name_file, $graph_name, $data_array_y, $data["data_all_time"], 'Количество заявок', 'Дата', 'Y-m', $max_y_scale, 0, $series_name_array, 1, $text_angle, $view_requests_type)
    private function chartCreater2($file_name, $chart_name, array $data_y, $data_x, $name_y, $name_x, $date_format, $max_YAxis, $text_angle_X, $series_name, $x_interval = 1, $view_requests_type)
    {
        include_once(__DIR__ . '/../vendor/pChart/pChart/pData.class');
        include_once(__DIR__ . '/../vendor/pChart/pChart/pChart.class');

        // Dataset definition
        $DataSet = new \pData;
        //  Debugger::Eho($date_format);
        // Debugger::testDie();

        $DataSet->SetXAxisFormat("date");
        $DataSet->AddPoint($data_x, "series_1x");

        $series_a = array();
//Debugger::PrintR($view_requests_type);
        foreach($data_y as $k => $v) {

            if( isset($view_requests_type["$k"]) ) {

               $DataSet->AddPoint($v, "series_$k");
                $DataSet->SetSerieName($series_name[$k], "series_$k");
                $series_a[] = "series_$k";
            }
        }

     //   Debugger::testDie();
        $DataSet->AddAllSeries();
        $DataSet->RemoveSerie("series_1x");

        $DataSet->SetAbsciseLabelSerie("series_1x");
        //$DataSet->SetSerieName("January","Serie1");
        //$DataSet->SetSerieName("February","Serie2");
        $DataSet->SetYAxisName($name_y);
        $DataSet->SetXAxisName($name_x);

        // Initialise the graph
        $Test = new \pChart(1170, 545);

        $requests_types_array = Yii::$app->params['requests_type'];

        foreach ($requests_types_array as $k => $v) {
            if($k !=5){
                $Test->setColorPalette($k-1,$v['color'][0], $v['color'][1], $v['color'][2]);
            }
        }
        //  $Test->setColorPalette(0, $color_pallet[0], $color_pallet[1], $color_pallet[2]);
        $Test->setFixedScale(0, $max_YAxis, 10);
        // Debugger::PrintR($series_a);
        // Debugger::Eho($max_YAxis);
        // Debugger::testDie();

        $Test->setDateFormat($date_format);
        //$Test->setFixedScale(0,4200,200);

        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 8);
        $Test->setGraphArea(70, 30, 1120, 450);
        $Test->drawFilledRoundedRectangle(7, 7, 1163, 538, 5, 240, 240, 240);
        $Test->drawRoundedRectangle(5, 5, 1165, 540, 5, 230, 230, 230);
        $Test->drawGraphArea(255, 255, 255, TRUE);
        $Test->drawScale($DataSet->GetData(), $DataSet->GetDataDescription(), SCALE_NORMAL, 0, 0, 0, TRUE, $text_angle_X, 0, TRUE, $x_interval);
        $Test->drawGrid(4, TRUE, 230, 230, 230, 50);

        // Draw the 0 line
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 6);
        $Test->drawTreshold(0, 143, 55, 72, TRUE, TRUE);

        // Draw the bar graph
        //  $Test->drawOverlayBarGraph($DataSet->GetData(), $DataSet->GetDataDescription());
        $Test->drawBarGraph($DataSet->GetData(), $DataSet->GetDataDescription(), TRUE);

        // Write values

        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 12);
        if (count($series_a) <= 4) {
            $Test->writeValues($DataSet->GetData(), $DataSet->GetDataDescription(), $series_a);
        }
        // Finish the graph
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 8);
        $Test->drawLegend(75, 35, $DataSet->GetDataDescription(), 255, 255, 255);
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 10);
        $Test->drawTitle(550, 22, $chart_name, 50, 50, 50, 585);
        $Test->Render(__DIR__ . '/../web/images/' . $file_name . '.png');

    }
    private function chartCreater3($file_name, $chart_name, array $data_y, $data_x, $name_y, $name_x, $max_YAxis, $text_angle_X=0, $series_name, $x_interval = 1, $view_requests_type)
    {
        include_once(__DIR__ . '/../vendor/pChart/pChart/pData.class');
        include_once(__DIR__ . '/../vendor/pChart/pChart/pChart.class');

        // Dataset definition
        $DataSet = new \pData;
        //  Debugger::Eho($date_format);
        // Debugger::testDie();

       // $DataSet->SetXAxisFormat("date");
        $DataSet->AddPoint($data_x, "series_1x");

        $series_a = array();


        foreach($data_y as $k => $v) {

            if('data_'.$view_requests_type == substr($k,0,-5)   ) {
              //  if( strpos($k, $view_requests_type) !== false ) {
             //   Debugger::Eho('</br>');
                $DataSet->AddPoint($v, "series_$k");
                $DataSet->SetSerieName($series_name[$k], "series_$k");
                $series_a[] = "series_$k";
            }
        }

        $DataSet->AddAllSeries();
        $DataSet->RemoveSerie("series_1x");

        $DataSet->SetAbsciseLabelSerie("series_1x");
        //$DataSet->SetSerieName("January","Serie1");
        //$DataSet->SetSerieName("February","Serie2");
        $DataSet->SetYAxisName($name_y);
        $DataSet->SetXAxisName($name_x);

        // Initialise the graph
        $Test = new \pChart(1170, 545);
        //  $Test->setColorPalette(0, $color_pallet[0], $color_pallet[1], $color_pallet[2]);
        $requests_types_array = Yii::$app->params['requests_type'];
        //Debugger::PrintR($requests_types_array);
        //  Debugger::testDie();


        $Test->setFixedScale(0, $max_YAxis, 10);
        // Debugger::PrintR($series_a);
        // Debugger::Eho($max_YAxis);
        // Debugger::testDie();

        //$Test->setDateFormat($date_format);
        //$Test->setFixedScale(0,4200,200);

        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 8);
        $Test->setGraphArea(70, 30, 1120, 450);
        $Test->drawFilledRoundedRectangle(7, 7, 1163, 538, 5, 240, 240, 240);
        $Test->drawRoundedRectangle(5, 5, 1165, 540, 5, 230, 230, 230);
        $Test->drawGraphArea(255, 255, 255, TRUE);
        $Test->drawScale($DataSet->GetData(), $DataSet->GetDataDescription(), SCALE_NORMAL, 0, 0, 0, TRUE, $text_angle_X, 0, TRUE, $x_interval);
        $Test->drawGrid(4, TRUE, 230, 230, 230, 50);

        // Draw the 0 line
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 6);
        $Test->drawTreshold(0, 143, 55, 72, TRUE, TRUE);

        // Draw the bar graph
        //  $Test->drawOverlayBarGraph($DataSet->GetData(), $DataSet->GetDataDescription());
        $Test->drawBarGraph($DataSet->GetData(), $DataSet->GetDataDescription(), TRUE);

        // Write values

        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 12);
        if (count($series_a) <= 4) {
            $Test->writeValues($DataSet->GetData(), $DataSet->GetDataDescription(), $series_a);
        }
        // Finish the graph
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 8);
        $Test->drawLegend(75, 35, $DataSet->GetDataDescription(), 255, 255, 255);
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 10);
        $Test->drawTitle(550, 22, $chart_name, 50, 50, 50, 585);
        $Test->Render(__DIR__ . '/../web/images/' . $file_name . '.png');

    }

    private function dateParsing($number)
    {

        $n = strlen($number) % 2 ? '0' . $number : $number;
        //echo $n.' ';
        $date_array = str_split($n, 2);

        $date = '';
        $date .= isset($date_array[0]) ? '20' . $date_array[0] : '';
        $date .= isset($date_array[1]) ? '-' . $date_array[1] : '-01';
        $date .= isset($date_array[2]) ? '-' . $date_array[2] : '-01';
        $date .= isset($date_array[3]) ? ' ' . $date_array[3] : ' 00';
        $date .= isset($date_array[4]) ? ':' . $date_array[4] : ':00';
        $date .= isset($date_array[5]) ? ':' . $date_array[5] : ':00';
        $date = strtotime($date);

        return $date;

    }

    private function cssColumnPosition($number_column)
    {
        $one_column_with_marg = 89.64 / ($number_column);
        $two_marg = $one_column_with_marg * 0.22222;//0.4685;
        $one_marg = $two_marg / 2;
        $column_w = $one_column_with_marg - $two_marg;
        $marg_left = 6.1;//6.067;
        return array(
            'column_w' => $column_w,
            'marg' => $one_marg,
            'marg_left' => $marg_left
        );
    }

    private function noDataRedirect()
    {
        $url = Yii::$app->request->url;


        $url_array = explode('/', $url);
        $param_array = explode("-", $url_array[2]);

        if ($url_array[2] == 'select-data' || $url_array[2] == 'multi-years') {

            return 1;
        }
        if (isset($param_array[2])) {
            $date_request = $param_array[1] . '-' . $param_array[2];
            $date_request_timestamp = Yii::$app->formatter->asTimestamp($date_request);
            // $date_now_timestamp = Yii::$app->formatter->asTimestamp('now');
            $date_now = Yii::$app->formatter->asDate('now', 'yyyy-MM');
            $date_now_timestamp = Yii::$app->formatter->asTimestamp($date_now);
            $date_before = Yii::$app->params['date-before-requests'];
            $date_before_array = explode("-", $date_before);
            $date_before = $date_before_array[0] . '-' . $date_before_array[1];
            $date_before_timestamp = Yii::$app->formatter->asTimestamp($date_before);
        } elseif (isset($param_array[1])) {
            $date_request = $param_array[1] . '-01';
            $date_request_timestamp = Yii::$app->formatter->asTimestamp($date_request);
            //$date_now_timestamp = Yii::$app->formatter->asTimestamp('now');
            $date_now = Yii::$app->formatter->asDate('now', 'yyyy') . '-01';
            $date_now_timestamp = Yii::$app->formatter->asTimestamp($date_now);
            $date_before = Yii::$app->params['date-before-requests'];
            $date_before_array = explode("-", $date_before);
            $date_before = $date_before_array[0] . '-01';
            $date_before_timestamp = Yii::$app->formatter->asTimestamp($date_before);
        } else {
            return null;
        }
        if (($date_request_timestamp < $date_before_timestamp) || ($date_request_timestamp > $date_now_timestamp)) {


            // $this->redirect('/charges/no-data');
            //exit();
            header('Location: /requests/no-data');
            exit;
        }
        return null;

    }




    private function getMenuItemsYears($org_id, $year = 0, $line = 0)
    {
        $menu_years_item = array();
        for ($i = 2008; $i <= Yii::$app->formatter->asDate(time(), 'Y'); $i++) {
            $menu_years_item[] = ['label' => "$i", 'url' => "/requests/$org_id-$i", "options" => ["id" => "$i"], 'active' => ("/requests/$org_id-$i" == Yii::$app->request->url || "/requests/$org_id-$i/line" == Yii::$app->request->url) ||
                strpos(Yii::$app->request->url, (string)$i)];

        }
        //   $menu_years_item[] = ['label' => "Таблица данных", 'url' => Yii::$app->request->url.'/table','options' => ['class' => 'navbar_right_menu']];

        if (!$line && !is_array($year)) {
            $y = '/todo/' . $org_id . '-' . $year . '/line';
            $name = 'Линейный график';
        } elseif ($line == 1 && !is_array($year)) {
            $y = '/todo/' . $org_id . '-' . $year;
            $name = 'Столбцовый график';
            /**
             * раскоментить если надо добавить кнопку линейного графика на странице мультивыбор по годам
             *
             * } elseif (!$line && is_array($year)) {
             * $year_string = '';
             * foreach ($year as $v) {
             * $year_string .= $v . '-';
             * }
             * $year_string = trim($year_string, '-');
             * $y = '/charges/' . $users_type . '/' . $year_string;
             * $name = 'Линейный график';
             * } elseif ($line && is_array($year)) {
             * $year_string = '';
             * foreach ($year as $v) {
             * $year_string .= $v . '-';
             * }
             * $year_string = trim($year_string, '-');
             * $y = '/charges/' . $users_type . '/' . $year_string . '/line';
             * $name = 'Столбцовый график';
             **/
        } elseif($line == 1 && is_array($year)) {
            $y = '#';
            $name = '#';
        }else{
            return $menu_years_item;
        }

        // убрать условие (!is_array($year)) если надо добавить кнопку линейного графика на странице мультивыбор по годам
        if (!is_array($year)) {
            $menu_years_item[] = '<li class="batton_position_8"> <p><a class="btn btn-default btn-lg" href="' . $y . '">' . $name . '</a></p></li>';

        }

        // "<li class='batton_position_1'><p ><a class='btn btn-default btn-lg' href='$url_total'> График общий </a></p></li>"
        return $menu_years_item;
    }

    private function getMenuItemsMonth($org_id, $year, $month, $line = 0)
    {
        $menu_month_item = array();
        for ($i = 1; $i <= 12; $i++) {

            $i_text = $i < 10 ? '0' . $i : $i;
            $menu_month_item[] = ['label' => "$i_text", 'url' => "/requests/$org_id-$year-$i_text", 'active' => ("/requests/$org_id-$year-$i_text" == Yii::$app->request->url || "/requests/$org_id-$year-$i_text/line" == Yii::$app->request->url)];
        }

        if (!$line) {
            $y = '/requests/' . $org_id . '-' . $year . '-' . $month . '/line';
            $name = 'Линейный график';
        } elseif($line ==1){
            $y = '/requests/' . $org_id . '-' . $year . '-' . $month;
            $name = 'Столбцовый график';
        } else {
            return $menu_month_item;
        }

        $menu_month_item[] = '<li class="batton_position_7"> <p><a class="btn btn-default btn-lg" href="' . $y . '">' . $name . '</a></p></li>';

        return $menu_month_item;
    }

    private function netType($number)
    {
        switch ($number) {
            case 1:
                return Yii::$app->params['request_org'][1];
                break;

            case 2:
                return Yii::$app->params['request_org'][2];
                break;

            case 3:
                return Yii::$app->params['request_org'][3];
                break;

            case 4:
                return Yii::$app->params['request_org'][4];
                break;

            case 5:
                return Yii::$app->params['request_org'][5];
                break;
            case 6:
                return Yii::$app->params['request_org'][6];
                break;

            default:
                return Yii::$app->params['request_org'][1];
        }
    }


    private function dataRequests(Requests $requestsModel, $format, $start_period, $end_period, $org_id, $total_dif_todostatus = null, $todo_status = null, $todo_location = null)
    {

        if ($format == 'Y') {
            $date_today = Yii::$app->formatter->asDate(time(), 'Y');
            $date_end_array = str_split($date_today, 2);
            $end_period = $end_period ? $end_period : $date_end_array[1] . +1;

        } elseif ($format == 'Ym') {
            $date_today = Yii::$app->formatter->asDate('now', 'yyyyMM');
            $date_end_array = str_split($date_today, 2);
            $end_period = $end_period ? $end_period : ($date_end_array[1] . +1) . $date_end_array[2];


        } elseif ($format == 'Ymd') {
            $date_today = Yii::$app->formatter->asDate(time(), 'Ymd');
            $date_end_array = str_split($date_today, 2);
            $end_period = $end_period ? $end_period : ($date_end_array[1] . +1) . $date_end_array[2] . $date_end_array[2];

        } else {
            throw new \PDOException('Введен не правильный формат даты');
        }

        $billing_org_id = array_flip(Yii::$app->params['request_org'][$org_id]['org_id']);



        $data = $requestsModel->RequestsSelect($start_period, $end_period,$billing_org_id);


        $total_data = array();
        $org_id_data = Yii::$app->params['request_org'];

        /*
         * Если  $org_id != 5(5 - это для всех сетей) то дальнейший скрипт разбивает полученные данные на разные массивы
         * каждый из которых соответствует тодо на той или иной стадии обработк. Подобная обработка нужна чтоб уменьшить
         * количество запросов в базу.
         */
        $data_arrays_name = array('', 'alfa', 'kuzia', 'nline', 'other', 'nonet');
        foreach ($data as $k => $v) {

            if (isset($data[$k]['ts'])) {
                if (strlen($data[$k]['ts']) > 6) {
                    $data[$k]['ts'] = round(($data[$k]['ts'] / 10000));
                }
            }
        }










        /*


        if ($org_id != 5) {
            $data_alfa = array();
            $data_kuzia = array();
            $data_nline = array();
            $data_other = array();
            $data_nonet = array();
            $data_connect = array();
            $data_alfa_connect = array();
            $data_kuzia_connect = array();
            $data_nline_connect = array();
            $data_other_connect = array();
            $data_nonet_connect = array();


            foreach ($data as $k => $v) {

                if (isset($org_id_data[2]['org_id'][$v['org_id']])) {
                    $data_alfa[] = $v;
                    if (isset($v['user_name'])) {
                        $data_alfa_connect[] = $v;
                    }
                } elseif (isset($org_id_data[1]['org_id'][$v['org_id']])) {
                    $data_kuzia[] = $v;
                    if (isset($v['user_name'])) {
                        $data_kuzia_connect[] = $v;
                    }
                } elseif (isset($org_id_data[3]['org_id'][$v['org_id']])) {
                    $data_nline[] = $v;
                    if (isset($v['user_name'])) {
                        $data_nline_connect[] = $v;
                    }
                } elseif (isset($org_id_data[4]['org_id'][$v['org_id']])) {
                    $data_other[] = $v;
                    if (isset($v['user_name'])) {
                        $data_other_connect[] = $v;
                    }
                } elseif (isset($org_id_data[6]['org_id'][$v['org_id']])) {
                    $data_nonet[] = $v;
                    if (isset($v['user_name'])) {
                        $data_nonet_connect[] = $v;
                    }
                }
                if (isset($v['user_name'])) {
                    $data_connect[] = $v;
                }
            }

            $data = array(
                'data' => $data,
                'data_alfa' => $data_alfa,
                'data_kuzia' => $data_kuzia,
                'data_nline' => $data_nline,
                'data_other' => $data_other,
                'data_nonet' => $data_nonet,
                'data_connect' => $data_connect,
                'data_alfa_connect' => $data_alfa_connect,
                'data_kuzia_connect' => $data_kuzia_connect,
                'data_nline_connect' => $data_nline_connect,
                'data_other_connect' => $data_other_connect,
                'data_nonet_connect' => $data_nonet_connect,
            );

        } else {
            $data_connect = array();
            foreach ($data as $k => $v) {
                if (isset($v['user_name'])) {
                    $data_connect[] = $v;
                }
            }
            $data = array(
                'data' => $data,
                'data_connect' => $data_connect,
            );
        }

        */











       // $data = array();
        $requests_type = Yii::$app->params['requests_type'];

        $data_all = $data;
        $data_net = array();
        $data_connect_home = array();
        $data_connect_corporate = array();
        $data_connect_all = array();


        foreach ($data as $k => $v){
            if(isset($v['status']) && ($v['status'] ==0 || $v['status'] ==1 || $v['status'] ==3) ){
                $data_net[] = $v;
            }
            if(isset($v['user_name'])){
                $data_connect_all[] = $v;
                if($v['user_class'] == 0){

                    $data_connect_home[] = $v;

                }elseif($v['user_class'] == 1){

                    $data_connect_corporate[] = $v;
                }
            }

        }

        $data = array(
            'data_all' => $data_all,
            'data_net' => $data_net,
            'data_connect_home' => $data_connect_home,
            'data_connect_corporate' => $data_connect_corporate,
            'data_connect_all' => $data_connect_all,
        );


//Debugger::PrintR($data['data_connect']);
     //   Debugger::testDie();


        /*
         * преобразование каждого из массивов данных различных состояний тодо, включая и общий массив, в формат массивов
         * пригодных для использования их в дальнейшем построении графиков
         */

        foreach ($data as $key_data => $value_data) {


            //    $e_p = $end_period < 100 ? $end_period : round($end_period / 100);
            //    $s_p = $start_period < 100 ? $start_period : round($start_period / 100);

            $n_e_p = strlen($end_period) % 2 ? '0' . $end_period : $end_period;
            $n_s_p = strlen($start_period) % 2 ? '0' . $start_period : $start_period;

            $s_p_array = str_split($n_s_p, 2);
            $e_p_array = str_split($n_e_p, 2);


            //Debugger::PrintR($value_data);
            foreach ($value_data as $k => $v) {
                //  $s = iconv('utf-8', 'windows-1252', $v['subj']);
                //   $value_data[$k]['subj'] = iconv('windows-1251', 'utf-8', $s);
                //   $value_data[$k]['subj'] = iconv('utf-8','windows-1252', $v['subj']);
                $init_time = $v['ts'];

                $n = strlen($init_time) % 2 ? '0' . $init_time : $init_time;
                $date_array = str_split($n, 2);
                $value_data[$k]['date_array'] = $date_array;
            }

            $data_array_dif = array();
            $index = ((int)$e_p_array[0] - (int)$s_p_array[0]) > 1 ? 0 : 1;
            for ($i = $s_p_array[0]; $i <= ($e_p_array[0] - $index); $i++) {

                $i = (int)$i;
                $data_array_dif[$i] = array();
                if ($format == 'Ym') {
                    if ($i != $e_p_array[0] && $i != $s_p_array[0]) {
                        for ($i_m = 1; $i_m < 13; $i_m++) {
                            $data_array_dif[$i][$i_m] = array();
                            if ($format == 'Ymd') {

                                if ($i_m == 1 || $i_m == 3 || $i_m == 5 || $i_m == 7 || $i_m == 8 || $i_m == 10 || $i_m == 12) {
                                    $index = 31;
                                } elseif ($i_m == 2) {
                                    $index = 29;
                                } else {
                                    $index = 30;
                                }
                                for ($i_d = 1; $i_d < $index; $i_d++) {
                                    $data_array_dif[$i][$i_m][$i_d] = array();
                                }
                            }
                        }
                    } elseif ($i == $e_p_array[0]) {
                        for ($i_m = 1; $i_m <= (int)$e_p_array[1]; $i_m++) {
                            $data_array_dif[$i][$i_m] = array();
                            if ($format == 'Ymd') {
                                if ($i_m == 1 || $i_m == 3 || $i_m == 5 || $i_m == 7 || $i_m == 8 || $i_m == 10 || $i_m == 12) {
                                    $index = 31;
                                } elseif ($i_m == 2) {
                                    $index = 29;
                                } else {
                                    $index = 30;
                                }
                                for ($i_d = 1; $i_d < $index; $i_d++) {
                                    $data_array_dif[$i][$i_m][$i_d] = array();
                                }
                            }
                        }
                    } elseif ($i == $s_p_array[0]) {
                        for ($i_m = (int)$s_p_array[1]; $i_m < 13; $i_m++) {
                            $data_array_dif[$i][$i_m] = array();
                            if ($format == 'Ymd') {
                                if ($i_m == 1 || $i_m == 3 || $i_m == 5 || $i_m == 7 || $i_m == 8 || $i_m == 10 || $i_m == 12) {
                                    $index = 31;
                                } elseif ($i_m == 2) {
                                    $index = 29;
                                } else {
                                    $index = 30;
                                }
                                for ($i_d = 1; $i_d < $index; $i_d++) {
                                    $data_array_dif[$i][$i_m][$i_d] = array();
                                }
                            }
                        }
                    }
                }
            }
            if ($format == 'Ym') {
                foreach ($value_data as $k => $v) {
                    $data_array_dif[(int)$v['date_array'][0]][(int)$v['date_array'][1]][] = $v;
                }
            } elseif ($format == 'Y') {
                foreach ($value_data as $k => $v) {
                    $data_array_dif[(int)$v['date_array'][0]][] = $v;
                }
            } elseif ($format == 'Ymd') {
                foreach ($value_data as $k => $v) {
                    $data_array_dif[(int)$v['date_array'][0]][(int)$v['date_array'][1]][(int)$v['date_array'][2]][] = $v;
                }
            }

            $data_tm = array();
            $data_count = array();
            if ($format == 'Ym') {
                foreach ($data_array_dif as $k => $v) {
                    foreach ($v as $key => $val) {
                        $count = count($val);
                        if ($key != 10 && $key != 11 && $key != 12) {
                            $data_tm[] = $k . '0' . $key;
                            $data_array_dif[$k][$key]['time'] = $k . '0' . $key;
                        } else {
                            $data_tm[] = $k . $key;
                            $data_array_dif[$k][$key]['time'] = $k . $key;
                        }

                        $data_count[] = $count;
                        $data_array_dif[$k][$key]['count'] = $count;
                    }
                }
            } elseif ($format == 'Y') {
                foreach ($data_array_dif as $k => $v) {
                    $count = count($v);
                    if ($k < 10) {
                        $data_tm[] = '0' . $k;
                        $data_array_dif[$k]['time'] = '0' . $k;
                    } else {
                        $data_tm[] = $k;
                        $data_array_dif[$k]['time'] = $k;
                    }
                    $data_count[] = $count;
                    $data_array_dif[$k]['count'] = $count;
                }
            } elseif ($format == 'Ymd') {
                foreach ($data_array_dif as $k => $v) {
                    foreach ($v as $key => $val) {
                        foreach ($val as $key_d => $val_d) {
                            $count = count($val_d);

                            if ($key != 10 && $key != 11 && $key != 12) {
                                if ($key_d < 10) {
                                    $data_tm[] = $k . '0' . $key . '0' . $key_d;
                                    $data_array_dif[$k][$key][$key_d]['time'] = $k . '0' . $key . '0' . $key_d;
                                } else {
                                    $data_tm[] = $k . '0' . $key . $key_d;
                                    $data_array_dif[$k][$key][$key_d]['time'] = $k . '0' . $key . $key_d;
                                }

                            } else {
                                if ($key_d < 10) {
                                    $data_tm[] = $k . $key . '0' . $key_d;
                                    $data_array_dif[$k][$key][$key_d]['time'] = $k . $key . '0' . $key_d;
                                } else {
                                    $data_tm[] = $k . $key . $key_d;
                                    $data_array_dif[$k][$key][$key_d]['time'] = $k . $key . $key_d;
                                }
                            }
                            $data_count[] = $count;
                            $data_array_dif[$k][$key][$key_d]['count'] = $count;
                        }
                    }
                }
            }

            $data_time = array();
            // Debugger::PrintR($data_tm);
            foreach ($data_tm as $key => $val) {
                $d = $this->dateParsing($val);
                $data_time[] = $d;
            }
            //


            $total_data["{$key_data}_requests"] = $data_count;
            $total_data["{$key_data}_time"] = $data_time;
            $total_data["{$key_data}"] = $data_array_dif;

         //   Debugger::Eho($key_data.'_requests');
          //  Debugger::Eho('</br>');
          //  Debugger::PrintR($total_data["{$key_data}_requests"]);
        }



        if ($format == 'Ym' && ((int)$end_period - (int)$start_period) <= 100) { //для графика по месяцам обрезает возникшие не корректные данные возникшие из-за ошибок в беза
            // данных.Появление хотяб одного некорректоно данного может привести к появлению 13 столбца в графике (вместо 12)
            foreach ($total_data as $k => $v) {
                if (strpos($k, '_time') || strpos($k, '_requests')) {
                    $n = count($v);
                    if ($n > 12) {
                        for ($i = $n; $n > 12; $i--) {
                            array_pop($total_data[$k]);
                            $n = count($total_data[$k]);
                        }
                    }
                }
            }
        }
      //  Debugger::Eho('requests');
        //Debugger::Eho('</br>');
      //  Debugger::PrintR($total_data["data_connect_requests"]);


        if ($format == 'Y') { //образка последнего значения (пустое). Для построения графика год указывается +1 относительно
            //текущего года, поэтому не содержит данных, его необходимо удалить.
            foreach ($total_data as $k => $v) {
                if (strpos($k, '_time') || strpos($k, '_requests')) {
                    array_pop($total_data[$k]);
                }

            }
        }

        // Для линейного графига делает массив данных на каждый день даже если за этот день не было данных
        $url_a = explode("/", Yii::$app->request->url);
        if ($format == 'Ymd' && isset($url_a[3]) && $url_a[3] == 'line') {

            $n_e_p = strlen($end_period) % 2 ? '0' . $end_period : $end_period;
            $n_s_p = strlen($start_period) % 2 ? '0' . $start_period : $start_period;

            $s_p_array = str_split($n_s_p, 2);
            $s_p_array[] = '01';
            $e_p_array = str_split($n_e_p, 2);
            $e_p_array[] = '01';


            $total_data['data_requests_full'] = array();
            $total_data['data_time_full'] = array();

            //  Debugger::PrintR($e_p_array);
            $end_p_y = ($s_p_array[0] == $e_p_array[0]) ? ((int)$e_p_array[0] + 1) : (int)$e_p_array[0];

            for ($i = (int)$s_p_array[0]; $i < $end_p_y; $i++) {

                $start_m = (int)$s_p_array[1] > 1 ? (int)$s_p_array[1] : 1;
                $end_m = (int)$s_p_array[1] > 1 ? (int)$s_p_array[1] : 12;
                for ($i_m = $start_m; $i_m <= $end_m; $i_m++) {
                    if ($i_m == 1 || $i_m == 3 || $i_m == 5 || $i_m == 7 || $i_m == 8 || $i_m == 10 || $i_m == 12) {
                        $index = 31;
                    } elseif ($i_m == 2) {
                        $index = 29;
                    } else {
                        $index = 30;
                    }

                    for ($i_d = 1; $i_d <= $index; $i_d++) {
                        $date_new = Yii::$app->formatter->asTimestamp(($i + 2000) . '/' . $i_m . '/' . $i_d);

                        $key_time_ymd = array_search($date_new, $total_data['data_time']);


                        if ($key_time_ymd !== false) {
                            $total_data['data_requests_full'][] = $total_data['data_requests'][$key_time_ymd];
                            $total_data['data_time_full'][] = $date_new;
                        } else {
                            $total_data['data_requests_full'][] = 0;
                            $total_data['data_time_full'][] = $date_new;
                        }

                    }
                }
            }
        }

      //  Debugger::PrintR($total_data["data_connect_requests"]);
/*
        if ($org_id != 5) {
            foreach ($data_arrays_name as $k_name => $v_name) {
                $data_new = array();


                if ($v_name) {

                    foreach ($total_data["data_{$v_name}_time"] as $k => $v) {
                        $n = array_search($v, $total_data["data_{$v_name}_connect_time"]);
                        //  Debugger::Eho($n);
                        //  Debugger::Eho('</br>');
                        if ($n!==null) {
                            //  Debugger::VarDamp($n);
                            $data_new[] = $total_data["data_{$v_name}_connect_requests"][$n];

                            //  $test[] = 1;
                            //  Debugger::Eho($total_data["data_{$v_name}_connect_requests_n"]);
                            //   Debugger::VarDamp($total_data["data_{$v_name}_connect_requests_n"]);

                        } else {
                            $data_new[] = 0;
                        }

                    }
                    // Debugger::PrintR($data_new);
                    // Debugger::Eho('</br>');
                    //Debugger::PrintR($total_data["data_{$v_name}_connect_requests_n"]);
                 //   unset($total_data["data_{$v_name}_connect_requests"]);
                   // Debugger::PrintR($total_data["data_{$v_name}_connect_requests"]);



                    $total_data["data_{$v_name}_connect_requests"] = $data_new;




                } else {
                    foreach ($total_data["data_time"] as $k => $v) {
                        $n = array_search($v, $total_data["data_connect_time"]);
                        if ($n!==null) {
                            $data_new[] = $total_data["data_connect_requests"][$n];
                        } else {
                            $data_new[] = 0;
                        }

                    }
                    $total_data["data_connect_requests"] = $data_new;
                }


            }

        } else {
            $data_new = array();
            foreach ($total_data["data_time"] as $k => $v) {
                $n = array_search($v, $total_data["data_connect_time"]);
                if ($n!==null) {
                    $data_new[] = $total_data["data_connect_requests"][$n];
                } else {
                    $data_new[] = 0;
                }

            }
            $total_data["data_connect_requests"] = $data_new;

        } */








      //  Debugger::PrintR($total_data["data_connect_requests"]);
    //    $test_u = array();
     //   foreach($total_data['data_alfa_time'] as $k => $v){
      //      $test_u[]= Yii::$app->formatter->asDate($v, 'Y-M-d');
       // }
    //    Debugger::PrintR($test_u);
        //Debugger::testDie();

      //  Debugger::PrintR($total_data['data_time']);
       // Debugger::PrintR($total_data['data_requests']);
       // Debugger::PrintR($total_data['data_connect_time']);
     //   Debugger::PrintR($total_data['data_connect_requests']);
       // Debugger::testDie();



        $data_new_net = array();
        $data_new_connect_home = array();
        $data_new_connect_corporate = array();
        $data_new_connect_all = array();
        foreach ($total_data["data_all_time"] as $k => $v) {




            $n_net = array_search($v, $total_data["data_net_time"]);
        //    Debugger::VarDamp($n_net);
            if ($n_net!==false && !empty($total_data["data_net_requests"])) {
                $data_new_net[] = $total_data["data_net_requests"][$n_net];

              //  Debugger::Eho('</br>');
            } else {
              //  Debugger::PrintR($data_new_net);
                $data_new_net[] = 0;
            }

            $n_connect_home = array_search($v, $total_data["data_connect_home_time"]);
            if ($n_connect_home!==false && !empty($total_data["data_connect_home_requests"])) {
                $data_new_connect_home[] = $total_data["data_connect_home_requests"][$n_connect_home];
            } else {
                $data_new_connect_home[] = 0;
            }

            $n_connect_corporate = array_search($v, $total_data["data_connect_corporate_time"]);
            if ($n_connect_corporate!==false && !empty($total_data["data_connect_corporate_requests"])) {
                //Debugger::PrintR();
              //  Debugger::testDie();
                $data_new_connect_corporate[] = $total_data["data_connect_corporate_requests"][$n_connect_corporate];
            } else {
                $data_new_connect_corporate[] = 0;
            }

            $n_connect_all = array_search($v, $total_data["data_connect_all_time"]);
            if ($n_connect_all!==false && !empty($total_data["data_connect_all_requests"])) {
                $data_new_connect_all[] = $total_data["data_connect_all_requests"][$n_connect_all];
            } else {
                $data_new_connect_all[] = 0;
            }

        }
       // Debugger::PrintR($total_data['data_all_requests']);
      //  Debugger::PrintR($total_data['data_net_requests']);
      //  Debugger::PrintR($total_data['data_net_requests']);
        $total_data["data_net_requests"] = $data_new_net;
        $total_data["data_connect_home_requests"] = $data_new_connect_home;
        $total_data["data_connect_corporate_requests"] = $data_new_connect_corporate;
        $total_data["data_connect_all_requests"] = $data_new_connect_all;

     //   Debugger::PrintR($total_data['data_all_requests']);
     //   Debugger::PrintR($total_data['data_net_requests']);
     //   Debugger::PrintR($total_data['data_connect_home_requests']);
     //   Debugger::PrintR($total_data['data_connect_corporate_requests']);
     //   Debugger::PrintR($total_data['data_connect_all_requests']);

       // Debugger::PrintR($total_data['data_all_time']);
       // Debugger::PrintR($total_data['data_net_time']);
       // Debugger::PrintR($total_data['data_connect_home_time']);
       // Debugger::PrintR($total_data['data_connect_corporate_time']);
       // Debugger::PrintR($total_data['data_connect_all_time']);

       // Debugger::testDie();

        return $total_data;
    }

    public function actionRequestsQuantityAll()
    {

        $url_array = explode("/", Yii::$app->request->url);
        $param_array = explode("-", $url_array[2]);

        $date_start_array = explode("-", Yii::$app->params['date-before-requests']);
        $start_period = str_split($date_start_array[0], 2)[1];


        $end_period = Yii::$app->formatter->asDate('now', 'yy');
        $end_period = (int)$end_period + 1;

        $org_id = $param_array[0];
        $net_type = $this->netType($org_id);
        $requests_type_array = Yii::$app->params['requests_type'];

        $requestsModel = new Requests();

        $label = $requestsModel->attributeLabels();
        //  $label_disconnection = $todoModel->attributeLabelsDisconnection();

        $graph_name = 'Заявки на подключение за весь период. (' . $net_type['name'] . ')';

        $chart_name_all = 'connect_requests_all';
        $name_file = 'all_requests';


        if (isset($url_array[3]) && $url_array[3] == 'line') {
            $start_period_line = $start_period . '01';
            $end_period_line = $end_period . '01';
            //$data_all = $this->todoData($todoModel, "Ym", $start_period_line, $end_period_line, $todo_type, 1);

            //   $max_y_scale = max($data_all['data_todo']) < 300 ? 300 : (max($data_all['data_todo']) + 50);

            //   $this->chartCreater2($todo_type['name_file'], $graph_name, $data_all['data_todo'], $data_all['data_time'], 'Количество заявок', 'Дата', 'Y-m-d', $max_y_scale, 90, Yii::$app->params['colors_todo'][$param_array[0]], 3);

            $years_number = 0;
            $css_data = 0;
        } else {
            $data_all = $this->dataRequests($requestsModel, "Y", $start_period, $end_period, $org_id);
            // $data_all_2 = $this->dataRequests($requestsModel, "Y", $start_period, $end_period, $org_id );

            //  $time_test = microtime(true) - $GLOBALS['start_time'];
            //  Debugger::Eho($time_test);
            // Debugger::PrintR($data_all);
            // Debugger::testDie();


            // $max_y_scale = max($data_all['data_requests']) < 1200 ? 1200 : (max($data_all['data_requests']) + 150);

            $years_number = count($data_all['data_all_time']);

            $css_data = $this->cssColumnPosition($years_number);


            //print_r($data_year);
            // Debugger::PrintR($data_year);

            $data_array_y = array();
            $series_name_array = array();
         //   $max_y_scale = '';

/*
            if ($param_array[0] != 5) {
                foreach (Yii::$app->params['request_org'] as $key => $v) {
                    if ($key == $param_array[0]) {
                        $k = $v['name_en'];
                        $data_array_y[$k] = $data_all["data_{$k}_requests"];
                        $data_array_y[$k . '_connect'] = $data_all["data_{$k}_connect_requests"];
                        $series_name_array[$k] = $v['name'] . '-все заявки';
                        $series_name_array[$k . '_connect'] = $v['name'] . '-подключения';
                        $max_y_scale = max($data_all["data_{$k}_requests"]) < 1200 ? 1200 : (max($data_all["data_{$k}_requests"]) + 150);
                    }


                }

                //   Debugger::PrintR($total_data['data_all_requests']);
                //   Debugger::PrintR($total_data['data_net_requests']);
                //   Debugger::PrintR($total_data['data_connect_home_requests']);
                //   Debugger::PrintR($total_data['data_connect_corporate_requests']);
                //   Debugger::PrintR($total_data['data_connect_all_requests']);

                // Debugger::PrintR($total_data['data_all_time']);
                // Debugger::PrintR($total_data['data_net_time']);
                // Debugger::PrintR($total_data['data_connect_home_time']);
                // Debugger::PrintR($total_data['data_connect_corporate_time']);
                // Debugger::PrintR($total_data['data_connect_all_time']);
            } else {
                */
                foreach($requests_type_array as $k=>$v){
                    $data_array_y["data_{$v['name_en']}"] = $data_all["data_{$v['name_en']}_requests"];
                    $series_name_array["data_{$v['name_en']}"] = $v['name'];
                }


                $max_y_scale = max($data_all['data_all_requests']) < 900 ? 900 : (max($data_all['data_all_requests']) + 150);
        //    }
            //  Debugger::Eho($param_array[0]);
            // Debugger::PrintR($data_array_y);
            // Debugger::testDie();


            /*
            $data_array_y = array(
                'data_income' => $data_year['data_income_todo'],
                'data_inwork' => $data_year['data_inwork_todo'],
                'data_complete' => $data_year['data_complete_todo'],
                'data_delete' => $data_year['data_delete_todo'],
                'data_repeat' => $data_year['data_repeat_todo'],
                'data' => $data_year['data_todo']
            );
*/
            // Debugger::PrintR($data_all);
            // Debugger::testDie();

            $this->chartCreater1($name_file, $graph_name, $data_array_y, $data_all['data_all_time'], 'Количество заявок', 'Дата', 'Y', $max_y_scale, 0, $series_name_array);
        }
        $line = 0;
        if (isset($url_array[3])) {
            if ($url_array[3] == 'table' && $param_array[0] != 6) {

                $views_name = 'requests_data_table';
            } elseif ($url_array[3] == 'table' && $param_array[0] == 6) {
                $views_name = 'requests_data_disconnections_table';
            } elseif ($url_array[3] == 'line') {
                $views_name = 'requests_all';
                $line = 1;
            } else {
                throw new Exception('Страница не найдена');
            }
        } else {
            $views_name = 'requests_all';
        }


        return $this->render($views_name, [
            'label' => $label,
            //  'label_disconnection' => $label_disconnection,
            'chart_name_year' => $chart_name_all,
            'data' => $data_all['data_all'],
            'org_id' => $param_array[0],
            'name' => $graph_name,//$todo_type['name'],
            'name_file' => $name_file,
            'line' => $line,
            'years_number' => $years_number,
            'start_period' => $start_period + 2000,
            'end_period' => $end_period + 2000,
            'css_data' => $css_data
        ]);
    }

    public function actionRequestsQuantityYear()
    {
        $this->noDataRedirect();

        $url_array = explode("/", Yii::$app->request->url);
        $param_array = explode("-", $url_array[2]);
        // print_r($param_array);
        $year_start_array = str_split($param_array[1], 2);
        $start_period = $year_start_array[1] . '01';

        $end_period = $year_start_array[1] < 9 ? '0' . ($year_start_array[1] + 1) . '01' : $year_start_array[1] + 1 . '01';

        //$todo_type = $this->todoType($param_array[0]);
        $org_id = $param_array[0];
        $net_type = $this->netType($org_id);
        $requests_type_array = Yii::$app->params['requests_type'];

        $requestsModel = new Requests();

        $label = $requestsModel->attributeLabels();
        // $label_disconnection = $todoModel->attributeLabelsDisconnection();

        $graph_name = 'Заявки на подключение за ' . $param_array[1] . ' год (' . $net_type['name'] . ')';
        $chart_name_year = 'connect_requests_year';
        $name_file = 'year_requests';


        if (isset($url_array[3]) && $url_array[3] == 'line') {
            /*
            $data_year = $this->todoData($todoModel, "Ymd", $start_period, $end_period, $todo_type, 1);
            if (empty($data_year['data'])) {
                header("Location: /todo/$url_array[2]/no-data-in-request");
                exit;
            }


            $max_y_scale = max($data_year['data_todo_full']) < 10 ? 10 : (max($data_year['data_todo_full']) + 5);

            $this->chartCreater2($todo_type['name_file'], $graph_name, $data_year['data_todo_full'], $data_year['data_time_full'], 'Количество заявок', 'Дата', 'Y-m-d', $max_y_scale, 90, Yii::$app->params['colors_todo'][$param_array[0]], 7);
*/
        } else {

            //$data_year = $this->todoData($todoModel, "Ym", $start_period, $end_period, $todo_type, 1);
            $data_year = $this->dataRequests($requestsModel, "Ym", $start_period, $end_period, $org_id);

            if (empty($data_year['data_all'])) {
                header("Location: /requests/$url_array[2]/no-data-in-request");
                exit;
            }
          //  $prefix_name_without_slash = $param_array[0] != 5 ? $net_type['name_en'] : '';
        //    $prefix_name = $param_array[0] != 5 ? $net_type['name_en'] . '_' : '';

         //   $max_y_scale = max($data_year["data_{$prefix_name}requests"]) < 150 ? 150 : (max($data_year["data_{$prefix_name}requests"]) + 25);




            $max_y_scale = max($data_year['data_all_requests']) < 150 ? 150 : (max($data_year['data_all_requests']) + 25);


            $month_number = count($data_year['data_all_time']);
            if ($month_number < 12) {
                $d_y = array();
                for ($i = 0; $i < 12; $i++) {
                    $i_plus = $i + 1;


                    if (($i_plus) < 10) {

                        $d = Yii::$app->formatter->asTimestamp("$param_array[1]-0$i_plus");
                    } else {
                        $d = Yii::$app->formatter->asTimestamp("$param_array[1]-$i_plus");
                    }
                    // echo $d.'</br>';
                    // echo $data_year['data_time'][$i].'</br>';
                    if (isset($data_year['data_all_time'][$i]) && $data_year['data_all_time'][$i] == $d) {
                        $d_y['data_all_time'][$i] = $d;
                        $d_y["data_all_requests"][$i] = $data_year["data_all_requests"][$i];
                    } else {
                        $d_y['data_all_time'][$i] = $d;
                        $d_y["data_all_requests"][$i] = '';
                    }
                }
                $d_y['data_all'] = $data_year['data_all'];

                $data_year = $d_y;
                // print_r($data_year);
            }



         //   $css_data = $this->cssColumnPosition($month_number);
            //print_r($data_year);
            // Debugger::PrintR($data_year);

            $data_array_y = array();
            $series_name_array = array();
            foreach($requests_type_array as $k=>$v){
                $data_array_y["data_{$v['name_en']}"] = $data_year["data_{$v['name_en']}_requests"];
                $series_name_array["data_{$v['name_en']}"] = $v['name'];
            }
/*

            $data_array_y["data_{$prefix_name_without_slash}"] = $data_year["data_{$prefix_name}requests"];
            $data_array_y["data_{$prefix_name}connect"] = $data_year["data_{$prefix_name}connect_requests"];
            $series_name_array['data_' . $prefix_name_without_slash] = $net_type['name'] . '-все заявки';
            $series_name_array['data_' . $prefix_name . 'connect'] = $net_type['name'] . '-подключения';

*/
            /*
            $data_array_y = array(
                'data_income' => $data_year['data_income_todo'],
                'data_inwork' => $data_year['data_inwork_todo'],
                'data_complete' => $data_year['data_complete_todo'],
                'data_delete' => $data_year['data_delete_todo'],
                'data_repeat' => $data_year['data_repeat_todo'],
                'data' => $data_year['data_todo']
            );
*/

            $this->chartCreater1($name_file, $graph_name, $data_array_y, $data_year['data_all_time'], 'Количество заявок', 'Дата', 'Y-m', $max_y_scale, 0, $series_name_array);
        }
        $line = 0;
        if (isset($url_array[3])) {
            if ($url_array[3] == 'table' && $param_array[0] != 6) {

                $views_name = 'todo_data_table';
            } elseif ($url_array[3] == 'table' && $param_array[0] == 6) {
                $views_name = 'todo_data_disconnections_table';
            } elseif ($url_array[3] == 'line') {
                $views_name = 'todo_year';
                $line = 1;
            } else {
                throw new Exception('Страница не найдена');
            }
        } else {
            $views_name = 'requests_year';
        }

$line = 2; //чтоб убрать кнопку линейного графика из вывода меню
        return $this->render($views_name, [
            'label' => $label,
            // 'label_disconnection' => $label_disconnection,
            'chart_name_year' => $chart_name_year,
            'data' => $data_year['data_all'],
            'year' => $param_array[1],
            'org_id' => $param_array[0],
            'name' => $graph_name,
            'name_file' => $name_file,
            'menu_items_years' => $this->getMenuItemsYears($param_array[0], $param_array[1], $line),
            'line' => $line,

        ]);
    }

    public function actionRequestsQuantityMonth()
    {

        // $this->redirect('/charges/no-data');

        $this->noDataRedirect();

        $url_array = explode("/", Yii::$app->request->url);

        $param_array = explode("-", $url_array[2]);
        // print_r($param_array);
        $year_start_array = str_split($param_array[1], 2);
        $start_period = $year_start_array[1] . $param_array[2];
        $end_period = $param_array[2] < 9 ? $year_start_array[1] . '0' . ($param_array[2] + 1) : $year_start_array[1] . ($param_array[2] + 1);

        $org_id = $param_array[0];
        $net_type = $this->netType($org_id);
        $requests_type_array = Yii::$app->params['requests_type'];

        $requestsModel = new Requests();

        $label = $requestsModel->attributeLabels();
        // $label_disconnection = $todoModel->attributeLabelsDisconnection();

        $graph_name = 'Заявки на подключение за ' . $param_array[1] . ' год, ' . $param_array[2] . ' месяц (' . $net_type['name'] . ')';
        $chart_name_month = 'connect_requests_month';
        $name_file = 'month_requests';


        $view_requests_type_id = array(1,2,3,4);
        $view_requests_type = array();//получение массива типов заявок в формате id -> name_en
        foreach($view_requests_type_id as $k=>$v){
            $view_requests_type["data_{$requests_type_array[$v]['name_en']}"] = $v;

        }


        if (isset($url_array[3]) && $url_array[3] == 'line') {
            /*
            $data_month = $this->todoData($todoModel, "Ymd", $start_period, $end_period, $todo_type, 1);
            if (empty($data_month['data'])) {
                header("Location: /todo/$url_array[2]/no-data-in-request");
                exit;
            }

            $max_y_scale = max($data_month['data_todo_full']) < 10 ? 10 : (max($data_month['data_todo_full']) + 5);
            $text_angle = count($data_month['data_todo_full']) < 15 ? 0 : 90;

            //Debugger::PrintR($data_month['data_todo_full']);
            // Debugger::testDie();
            $this->chartCreater5($todo_type['name_file'], $graph_name, $data_month['data_todo_full'], $data_month['data_time_full'], 'Количество заявок', 'Дата', 'Y-m-d', $max_y_scale, $text_angle, Yii::$app->params['colors_todo'][$param_array[0]], 1);
*/
        } else {
            $data_month = $this->dataRequests($requestsModel, "Ymd", $start_period, $end_period, $org_id);
            $prefix_name_without_slash = $param_array[0] != 5 ? $net_type['name_en'] : '';
            $prefix_name = $param_array[0] != 5 ? $net_type['name_en'] . '_' : '';
           // Debugger::PrintR($data_month["data_{$prefix_name}requests"]);
           // Debugger::testDie();
           // Debugger::PrintR($data_month['data_alfa_requests']);
           // Debugger::PrintR($data_month['data_alfa_connect_time']);
           // Debugger::PrintR($data_month['data_alfa_connect_requests']);
            if (empty($data_month["data_all_requests"])) {
                header("Location: /requests/$url_array[2]/no-data-in-request");
                exit;
            }



          //  $max_y_scale = max($data_month["data_{$prefix_name}requests"]) < 10 ? 10 : (max($data_month["data_{$prefix_name}requests"]) + 4);
            $max_y_scale = max($data_month['data_all_requests']) < 10 ? 10 : (max($data_month['data_all_requests']) + 4);


            $text_angle = count($data_month["data_all_requests"]) < 15 ? 0 : 90;

            $data_array_y = array();


            $data_array_y = array();
            $series_name_array = array();
            foreach($requests_type_array as $k=>$v){
                $data_array_y["data_{$v['name_en']}"] = $data_month["data_{$v['name_en']}_requests"];
                $series_name_array["data_{$v['name_en']}"] = $v['name'];
            }


            //$data_array_y["data_{$prefix_name_without_slash}"] = $data_month["data_{$prefix_name}requests"];
           // $data_array_y["data_{$prefix_name}connect"] = $data_month["data_{$prefix_name}connect_requests"];
           // $series_name_array['data_' . $prefix_name_without_slash] = $net_type['name'] . '-все заявки';
           // $series_name_array['data_' . $prefix_name . 'connect'] = $net_type['name'] . '-подключения';




            $this->chartCreater2($name_file, $graph_name, $data_array_y, $data_month["data_all_time"], 'Количество заявок', 'Дата', 'Y-m-d', $max_y_scale, $text_angle, $series_name_array, 1,$view_requests_type );
        }
        $line = 0;
        if (isset($url_array[3])) {
            if ($url_array[3] == 'table' && $param_array[0] != 6) {
                $views_name = 'todo_data_table';
            } elseif ($url_array[3] == 'table' && $param_array[0] == 6) {
                $views_name = 'todo_data_disconnections_table';
            } elseif ($url_array[3] == 'line') {
                $views_name = 'todo_month';
                $line = 1;
            } else {
                throw new Exception('Страница не найдена');
            }
        } else {
            $views_name = 'requests_month';
        }
        //не выводить кнопку ленейного графика
        $line = 2;


        return $this->render($views_name, [
            'label' => $label,

            'chart_name_month' => $chart_name_month,
            'data' => $data_month['data_all'],
            'year' => $param_array[1],
            'org_id' => $param_array[0],
            'name' => $graph_name,
            'month' => $param_array[2],
            'name_file' => $name_file,
            'menu_items_month' => $this->getMenuItemsMonth($param_array[0], $param_array[1], $param_array[2], $line),
            'line' => isset($line) ? 1 : null
        ]);


    }



    public function actionSelectData($year_start_table = null, $year_end_table = null, $todo_type_table = null, $todo_status_table = null, $todo_location_table = null)
    {


        $requestsModel = new Requests();
        $modelRequestsForm = new RequestsForm();


        $u = explode('?', Yii::$app->request->url);

        $url_array = explode("/", $u[0]);

        $label = $requestsModel->attributeLabels();
      //  $label_disconnection = $todoModel->attributeLabelsDisconnection();
        $date_today = Yii::$app->formatter->asDate('now', 'yyyy');

     //   $todo_type = 2;
        $org_id = 5;
        $net_type = $this->netType($org_id);
        $requests_type_array = Yii::$app->params['requests_type'];
        $requests_type_array_checkbox = array();
        foreach($requests_type_array as $k=>$v){
            $requests_type_array_checkbox[$k] = $v['name'];
        }
      //  $todo_type_array = Yii::$app->params['todo_type'][$todo_type];
        $start_year = ($date_today - 1999) - Yii::$app->params['year-period-select-requests'];
        $end_year = ($date_today - 1999);
        $start_period = $start_year . '01';
        $end_period = ($end_year) . '01';

        //   $start_period = 1201;
        //   $end_period = 1301;

        $view_requests_type_id = array(1,2,5);

     //   $todo_status = 0;//все
       // $todo_location = 0; //все
//Debugger::Eho($start_year);

        if (Yii::$app->request->post()) {
            if (Yii::$app->request->post('RequestsForm')['year_from'] <= Yii::$app->request->post('RequestsForm')['year_to']) {
                $requests_o = Yii::$app->request->post('RequestsForm')['requests_org'];
                $requests_t = Yii::$app->request->post('RequestsForm')['requests_type'];
              //  $todo_type_array = Yii::$app->params['RequestsForm'][$todo_t];
                $start_p = Yii::$app->request->post('RequestsForm')['year_from'];
                $end_p = (Yii::$app->request->post('RequestsForm')['year_to'] + 1);


                $modelRequestsForm->year_to = ($end_p - 1);
                $modelRequestsForm->year_from = $start_p;
                $modelRequestsForm->requests_org = $requests_o;
                $modelRequestsForm->requests_type = $requests_t;

               // Debugger::Eho($modelRequestsForm->requests_type);
             //   Debugger::PrintR($requests_t);
              //  Debugger::testDie();


            } else {
                Yii::$app->session->addFlash('dateHight', 'Дата начала приода должна быть меньше даты окончания периода! Введите данные еще раз.');

            }

        }


        if (isset($start_p) && isset($end_p) && isset($requests_o)  && isset($requests_t)) {

            $org_id = $requests_o;
            $start_year = $start_p;
            $end_year = $end_p;
            $view_requests_type_id = $requests_t;

            $start_period = $start_year . '01';
            $end_period = $end_year . '01';

        }
        $net_type = $this->netType($org_id);

        $view_requests_type = array();//получение массива типов заявок в формате  name_en ->id
        foreach($view_requests_type_id as $k=>$v){
            $view_requests_type["data_{$requests_type_array[$v]['name_en']}"] = $v;

        }


        if (isset($year_start_table) && isset($year_end_table) && isset($requests_org_table)) {
/* раскаментить для таблиц и поправить
            $todo_type = $todo_type_table;
            $start_year = round($year_start_table / 100);
//Debugger::Eho($start_year);
            //    Debugger::testDie();
            $end_year = round($year_end_table / 100);

            $start_period = $year_start_table;
            $end_period = $year_end_table;
            $todo_status = $todo_status_table;
            $todo_location = $todo_location_table;
            $todo_type_array = Yii::$app->params['todo_type'][$todo_type];  */ //раскоментить для таблиц
        }


        //  Debugger::testDie();
        //$todo_type_array = $this->todoType($todo_type);

        //Debugger::Eho($todo_type);
        //Debugger::Eho('</br>');
        //Debugger::Eho($start_period);
        //Debugger::Eho('</br>');
        //Debugger::Eho($end_period);
        //Debugger::Eho('</br>');
        //Debugger::Eho($todo_status);
        //Debugger::Eho('</br>');
        //Debugger::Eho($todo_location);

    //    $data = $this->todoData($todoModel, "Ym", $start_period, $end_period, $todo_type_array, 1, $todo_status, $todo_location);
        $data = $this->dataRequests($requestsModel, "Ym", $start_period, $end_period, $org_id);

     //   $prefix_name_without_slash = $org_id != 5 ? $net_type['name_en'] : '';
      //  $prefix_name = $org_id != 5 ? $net_type['name_en'] . '_' : '';
      //  Debugger::Eho($prefix_name);
       // Debugger::testDie();
//Debugger::PrintR($data);
        //      Debugger::testDie();
        $name_file = 'requests_select_data';

        $requests_name_org =  $net_type['name'];// isset(Yii::$app->params['todo_status'][$todo_status]['name']) ? Yii::$app->params['todo_status'][$todo_status]['name'] : 'Все';


        //Debugger::Eho(($start_year + 2000));
        $graph_name = 'Заявки на подключение. Период с  ' . ((int)$start_year + 2000) . '-01 по, ' . ((int)$end_year + 1999) . ' -12. (' . $requests_name_org . ')';
     //   $graph_name = $todo_type_array['name'] . '. Период с  ' . ((int)$start_year + 2000) . '-01 по, ' . ((int)$end_year + 1999) . '-12. Статус TODO - "' . $todo_status_name . '". Сеть - "' . $todo_location_name . '".';

      //  $max_y_scale = max($data['data_todo']) < 200 ? 200 : (max($data['data_todo']) + 25);
        $max_y_scale = max($data["data_all_requests"]) < 40 ? 40 : (max($data["data_all_requests"]) + 5);

        $text_angle = count($data["data_all_time"]) < 15 ? 0 : 90;

        if (($end_period - $start_period) > 100) {
            foreach($requests_type_array as $k=>$v){
                array_pop($data["data_{$v['name_en']}_requests"]); //удаление последнего пустого значения
                array_pop($data["data_{$v['name_en']}_time"]);//удаление последнего пустого значения
            }
        }


        $data_array_y = array();
        $series_name_array = array();
        foreach($requests_type_array as $k=>$v){
            $data_array_y["data_{$v['name_en']}"] = $data["data_{$v['name_en']}_requests"];
            $series_name_array["data_{$v['name_en']}"] = $v['name'];
        }


      //  $this->chartCreater2($todo_type_array['name_file'], $graph_name, $data['data_todo'], $data['data_time'], 'Количество TODO', 'Дата', 'Y-m', $max_y_scale, $text_angle, Yii::$app->params['colors_todo'][$todo_type]);
        $this->chartCreater2($name_file, $graph_name, $data_array_y, $data["data_all_time"], 'Количество заявок', 'Дата', 'Y-m', $max_y_scale, $text_angle, $series_name_array, 1, $view_requests_type);
        if (isset($url_array[3])) {
            $line = null;
            if ($url_array[3] == 'table') {
                $views_name = 'requests_data_table';
            } elseif ($url_array[3] == 'line') {
                $views_name = 'select-data';
                $line = 1;
            } else {
                throw new Exception('Страница не найдена');
            }
        } else {
            $views_name = 'select-data';
        }


        $years_array = array();
        for ($i = 2008; $i <= ((int)$date_today); $i++) {
            $years_array[$i - 2000] = $i;
        }
        /*
        $todo_type_a = array();
        for ($i = 1; $i <= 6; $i++) {
            $todo_type_a[$i] = $this->todoType($i)['name'];
        }
        $todo_status_a[] = 'Все';
        foreach (Yii::$app->params['todo_status'] as $k => $v) {
            $todo_status_a[] = $v['name'];
        }
*/
        $org_id_array = array();
        foreach(Yii::$app->params['request_org'] as $k => $v){
            $org_id_array[$k] = $v['name'];
        }

        return $this->render($views_name, [
            'label' => $label,
         //   'label_disconnection' => $label_disconnection,
           // 'chart_name_year' => $chart_name_year,
            'data' => $data,
            //  'year' => $param_array[1],
          //  'todo_type' => $todo_type,
            'org_id' => $org_id,
            'name' => $graph_name,
            'name_file' => $name_file,
            'menu_items_years' => $this->getMenuItemsYears($org_id),
            'start_period' => $start_period,
            'end_period' => $end_period,
            'start_year' => $start_year,
            'end_year' => $end_year,
            'model_requests_form' => $modelRequestsForm,
            'years_array' => $years_array,
            'org_id_array' => $org_id_array,
            'requests_type_array' => $requests_type_array_checkbox,
            'selected_requests_type_array' =>$view_requests_type_id,

           // 'todo_status_a' => $todo_status_a,
            //'todo_location_a' => $todo_location_a,
            //'todo_location' => $todo_location,
            //'todo_location_name' => $todo_location_name,
          //  'todo_status' => $todo_status,
          //  'todo_status_name' => $todo_status_name,
        ]);
    }



    public function actionSelectDataMultiYears($years_get = null, $requests_org_get = null, $requests_type_get = null)
    {
        $requestsModel = new Requests();
        $modelRequestsMultiYearsForm = new RequestsMultiYearsForm();
        $u = explode('?', Yii::$app->request->url);

        $url_array = explode("/", $u[0]);




        $label = $requestsModel->attributeLabels();
        $date_today = Yii::$app->formatter->asDate('now', 'yyyy');
        $year_array = array();


        $year_start_array = explode("-", Yii::$app->params['date-before-requests']);
        $start_period = ($year_start_array[0] - 2000);


        $end_period = (Yii::$app->formatter->asDate('now', 'yyyy') - 1999);

        $years_array_full = array();
        for ($i = $year_start_array[0]; $i <= ((int)$end_period + 1999); $i++) {
            $years_array_full[] = $i;
        }



        $start_period = $start_period . '01';
        $end_period = ($end_period) . '01';


        $org_id = '';
      //  $view_requests_type_id = array();
        $requests_type = '';

        $requests_type_array = Yii::$app->params['requests_type'];
        $requests_type_array_checkbox = array();
        foreach($requests_type_array as $k=>$v){
            $requests_type_array_checkbox[$k] = $v['name'];
        }



        if (Yii::$app->request->post()) {
            $org_i = Yii::$app->request->post('RequestsMultiYearsForm')['requests_org'];
            $year_array = Yii::$app->request->post('RequestsMultiYearsForm')['years'];
            $requests_t = Yii::$app->request->post('RequestsMultiYearsForm')['requests_type'];


            $org_id = $org_i;
            $requests_type = $requests_t;
            //$modelRequestsMultiYearsForm->years = $year_array;
          //  $view_requests_type_id = $requests_t;
         //   Debugger::Eho($org_i);
          //  Debugger::PrintR($year_array);
          //  Debugger::Eho($requests_t);
         //   Debugger::testDie();

        } elseif (isset($years_get) && isset($requests_org_get) && isset($requests_type_get)) {


            $org_id = $requests_org_get;
            $requests_type = $requests_type_get;
            $year_array = explode('-', $years_get);
           // $view_requests_type_id = $requests_type_get;




        } else {
            $org_id = 5;
          //  $view_requests_type_id = array(1);
            $years_number = Yii::$app->params['years-compare'];
            $requests_type = 1;

            $year_array = array_slice($years_array_full, -$years_number);

            sort($year_array);

        }

/*
        $view_requests_type = array();//получение массива типов заявок в формате  name_en ->id
        foreach($view_requests_type_id as $k=>$v){
            $view_requests_type["data_{$requests_type_array[$v]['name_en']}"] = $v;

        }
        Debugger::PrintR($view_requests_type);
        Debugger::testDie();
*/

        $net_type = $this->netType($org_id);
        $requests_type_array = Yii::$app->params['requests_type'];
        $requests_type_array_checkbox = array();
        foreach($requests_type_array as $k=>$v){
            $requests_type_array_checkbox[$k] = $v['name'];
        }

       // $users_type = $this->usersType($users_ty);


        $years_string = '';
        foreach ($year_array as $v) {
            $years_string .= $v . '-';
        }
        $years_string = trim($years_string, '-');


       // $user_class_unuse = $users_ty > 3 ? 1 : 0;

        $graph_name = 'Заявки для сети "' .$net_type['name'] . '", ' . $years_string . ' год';
        $chart_name_year = 'requests_multi_year';

//Debugger::Eho($start_period);
        //Debugger::Eho('</br>');
        //Debugger::Eho($end_period);
       // Debugger::Eho('</br>');
      //  Debugger::Eho($org_id);
        //
        $data_year = $this->dataRequests($requestsModel, "Ym", $start_period, $end_period, $org_id);
      //  Debugger::PrintR($data_year['data_all_requests']);

        //////////////////////////////////////
      //  Debugger::PrintR($year_array);

      //  $data_year_f_s = $this->multiYearsDataParsing($data_year, $year_array);
      //  $data_years_simple = $data_year_f_s['simple'];
      //  $data_years_full = $data_year_f_s['full'];
        $selected_years_timestamp = array();
        foreach($year_array as $k=>$v){

            for ($i = 1; $i <= 12; $i++) {
                $selected_years_timestamp[] = Yii::$app->formatter->asTimestamp($v.'-'.$i);
            }
        }
        $data_year_new = array();
        foreach($requests_type_array as $k=>$v){
            $name_requests = 'data_'.$v['name_en'].'_requests';
            $name_time = 'data_'.$v['name_en'].'_time';
            foreach($data_year[$name_time] as $key=>$value){
             //   Debugger::PrintR($data_year[$name_time]);
              //  Debugger::PrintR($selected_years_timestamp);
              //  Debugger::testDie();
                if(array_search($value,$selected_years_timestamp) !==false){
                    $year = Yii::$app->formatter->asDate($value, 'yyyy');
                    $data_year_new[$name_time.'_'.$year][]= $value;
                    $data_year_new[$name_requests.'_'.$year][]= $data_year[$name_requests][$key];
                }
            }

        }
     //   Debugger::PrintR($data_year_new);



        $data_array_y = array();
        $series_name_array = array();
        foreach($requests_type_array as $k=>$v){
            foreach($year_array as $key=>$value){
                $data_array_y["data_{$v['name_en']}_{$value}"] = $data_year_new["data_{$v['name_en']}_requests_{$value}"];
                $series_name_array["data_{$v['name_en']}_{$value}"] = $v['name'].'_'.$value;
            }

        }




     //   Debugger::PrintR($data_array_y);
       // Debugger::testDie();
/*

        $data_time = array();
        for ($i = 1; $i <= 12; $i++) {
            $data_time[] = $i;
        }
        // получение массивов с данными для оси y по указанным в урле годам $url_array[3]
        $data_y_array = array();
        $data_table_array = array();


        foreach ($year_array as $v) {
            $data_y_array[$v] = $data_years_simple[$v];
            $data_table_array[$v] = $data_years_full[$v];
        }
*/
        $data_max_array = array();
        foreach($year_array as $key=>$value){
            $name='data_all_'.$value;
            $data_max_array[] = max($data_array_y[$name]);
        }

        $max_data = max($data_max_array);

        $max_y_scale = $max_data < 250 ? 250 : ($max_data + 25);


        $graph_name = 'Заявки на подключение за ' . $years_string . ' года. (Сеть: ' . $net_type['name'].'. Тип заявок: ' . $requests_type_array[$requests_type]['name'] .'.)';

        $name_file = 'multy_year_requests';
        $data_time = array(1,2,3,4,5,6,7,8,9,10,11,12);// месяца для графика
        $requests_type_name = $requests_type_array[$requests_type]['name_en'];
     //   Debugger::Eho($requests_type_name);
      //  Debugger::testDie();



     //   Debugger::testDie();
        $this->chartCreater3($name_file, $graph_name, $data_array_y, $data_time, 'Количество заявок', 'Дата, месяц', $max_y_scale, 0, $series_name_array,1, $requests_type_name);

       // $this->chartCreater5($users_type['name_file'], $graph_name, $data_y_array, $data_time, 'Выручка, тысяч грн', 'Дата, месяц', $max_y_scale, 0);


        $line = 0;
        if (isset($url_array[3])) {
            if ($url_array[3] == 'table') {

                $views_name = 'get_data_table';
            } elseif ($url_array[3] == 'line') {
                $views_name = 'select-data-multi-years';
                $line = 1;
            } else {
                $views_name = 'select-data-multi-years';
            }
        } else {
            $views_name = 'select-data-multi-years';
        }
        //die('ups');



        $year_year_array_full = array();
        foreach ($years_array_full as $v) {
            $year_year_array_full[$v] = $v;
        }

        $org_id_array = array();
        foreach(Yii::$app->params['request_org'] as $k => $v){
            $org_id_array[$k] = $v['name'];
        }


        return $this->render($views_name, [
            'label' => $label,
            'chart_name_year' => $chart_name_year,
         //   'data' => $data_table_array,
            'year_string' => $years_string,
          //  'user_type' => $users_ty,
            'requests_org' => $org_id,
            'requests_type' => $requests_type,
            'requests_type_array' => $requests_type_array_checkbox,
            'name' => $graph_name,
            'name_file' => $name_file,
            'menu_items_years' => $this->getMenuItemsYears($org_id, $year_array, $line),
            'model_multi_years_form' => $modelRequestsMultiYearsForm,
            'year_array_all' => $year_year_array_full,
            'years_selected' =>$year_array,
            'url_part_2' => $url_array[2],
            'date_today' => $date_today,
            'org_id_array' => $org_id_array,
            //       'line' => $line
        ]);


    }





}