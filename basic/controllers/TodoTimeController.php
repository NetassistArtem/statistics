<?php


namespace app\controllers;


use app\components\debugger\Debugger;
use yii\web\Controller;
use app;
use Yii;
use yii\base\Exception;
use app\models\TodoTime;
use app\models\TodoTimeForm;

class TodoTimeController extends Controller
{


    private function chartCreater1($file_name, $chart_name, $date_format, $data_y_right, $data_y_left, $data_x, $name_y_right, $name_y_left, $name_x, $max_YAxis_right, $max_YAxis_left, $text_angle_X, array $color_pallet, $x_interval = 1, $graph_type = 1)
    {

        include_once(__DIR__ . '/../vendor/pChart/pChart/pData.class');
        include_once(__DIR__ . '/../vendor/pChart/pChart/pChart.class');

        // Dataset definition
        $DataSet = new \pData;
        $DataSet->AddPoint($data_y_right, "Serie1");
        $DataSet->AddPoint(array(), "Serie1e");
        $DataSet->AddPoint($data_y_left, "Serie2");
        $DataSet->AddPoint(array(), "Serie2e");
        $DataSet->AddPoint($data_x, "Serie3");
        $DataSet->AddSerie("Serie1");
        $DataSet->AddSerie("Serie1e");

        $DataSet->SetAbsciseLabelSerie("Serie3");
        $DataSet->SetSerieName("Среднее время обработки ТОДО, час", "Serie1");
        $DataSet->SetSerieName("Количество заявок", "Serie2");

        $DataSet->SetXAxisFormat("date");
        $DataSet->SetXAxisName($name_x);


        // Initialise the graph
        $Test = new \pChart(1170, 545);
        $Test->setColorPalette(0, $color_pallet['hours'][0], $color_pallet['hours'][1], $color_pallet['hours'][2]);

        $Test->setFixedScale(0, $max_YAxis_right, 10);
        $Test->setDateFormat($date_format);

        // $Test->drawGraphAreaGradient(90,90,90,90,TARGET_BACKGROUND);

        // Prepare the graph area
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 10);
        $Test->setGraphArea(70, 30, 1120, 450);

        // Initialise graph area
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 10);
        //  $Test->setGraphArea(70, 30, 1120, 450);
        $Test->drawFilledRoundedRectangle(7, 7, 1163, 538, 5, 240, 240, 240);
        $Test->drawRoundedRectangle(5, 5, 1165, 540, 5, 230, 230, 230);
        $Test->drawGraphArea(255, 255, 255, TRUE);

        // Draw the SourceForge Rank graph
        $DataSet->SetYAxisName("$name_y_left");
        $Test->drawScale($DataSet->GetData(), $DataSet->GetDataDescription(), SCALE_NORMAL, $color_pallet['hours'][0], $color_pallet['hours'][1], $color_pallet['hours'][2], TRUE, $text_angle_X, 0, TRUE, $x_interval);
        $Test->drawGrid(4, TRUE, 230, 230, 230, 50);

//выбор типа графика, одноколончный или двухколоночный
        if ($graph_type == 1) {
            $Test->drawStackedBarGraph($DataSet->GetData(), $DataSet->GetDataDescription(), 20);
        } elseif ($graph_type == 2) {
            $Test->drawBarGraph($DataSet->GetData(), $DataSet->GetDataDescription(), TRUE);//график с двумя колонками
        }
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 12);
        $Test->writeValues($DataSet->GetData(), $DataSet->GetDataDescription(), array('Serie1'));
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 10);

        // Clear the scale
        $Test->clearScale();

        // Draw the 2nd graph
        $DataSet->RemoveSerie("Serie1");
        $DataSet->RemoveSerie("Serie1e");

        $DataSet->AddSerie("Serie2e");
        $DataSet->AddSerie("Serie2");
        $DataSet->SetYAxisName("$name_y_right");


        $Test->setColorPalette(1, $color_pallet['todo'][0], $color_pallet['todo'][1], $color_pallet['todo'][2]);
        $Test->setFixedScale(0, $max_YAxis_left, 10);
        $Test->setDateFormat($date_format);
        $Test->drawRightScale($DataSet->GetData(), $DataSet->GetDataDescription(), SCALE_NORMAL, $color_pallet['todo'][0], $color_pallet['todo'][1], $color_pallet['todo'][2], TRUE, $text_angle_X, 0, TRUE, $x_interval);

        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 6);
        $Test->drawTreshold(0, 143, 55, 72, TRUE, TRUE);

        //выбор типа графика, одноколончный или двухколоночный

        if ($graph_type == 1) {
            $Test->drawStackedBarGraph($DataSet->GetData(), $DataSet->GetDataDescription(), 20);
        } elseif ($graph_type == 2) {
            $Test->drawBarGraph($DataSet->GetData(), $DataSet->GetDataDescription(), TRUE);//график с двумя колонками
        }

        // Write the legend (box less)
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 10);
        $Test->drawLegend(75, 35, $DataSet->GetDataDescription(), 255, 255, 255);
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 10);
        $Test->drawTitle(550, 22, $chart_name, 50, 50, 50, 585);

        // Write values

        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 12);
        $Test->writeValues($DataSet->GetData(), $DataSet->GetDataDescription(), array('Serie2'));

        // Render the picture
        $Test->Render(__DIR__ . '/../web/images/' . $file_name . '.png');
    }

    private function todoType($number)
    {
        switch ($number) {
            case 1:
                return Yii::$app->params['todo_type'][1];
                break;

            case 2:
                return Yii::$app->params['todo_type'][2];
                break;

            case 3:
                return Yii::$app->params['todo_type'][3];
                break;

            case 4:
                return Yii::$app->params['todo_type'][4];
                break;

            case 5:
                return Yii::$app->params['todo_type'][5];
                break;
            case 6:
                return Yii::$app->params['todo_type'][6];
                break;

            default:
                return Yii::$app->params['todo_type'][1];
        }
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

    private function getMenuItemsYears($todo_type, $todo_status, $year = 0, $line = 0)
    {
        $menu_years_item = array();
        for ($i = 2008; $i <= Yii::$app->formatter->asDate(time(), 'Y'); $i++) {
            $menu_years_item[] = ['label' => "$i", 'url' => "/todo-time/$todo_type-$i-$todo_status", "options" => ["id" => "$i"], 'active' => ("/todo-time/$todo_type-$i-$todo_status" == Yii::$app->request->url || "/todo-time/$todo_type-$i-$todo_status/line" == Yii::$app->request->url || "/todo-time/$todo_type-$i-$todo_status/two-columns" == Yii::$app->request->url) ||
                strpos(Yii::$app->request->url, (string)$i)];

        }
        //   $menu_years_item[] = ['label' => "Таблица данных", 'url' => Yii::$app->request->url.'/table','options' => ['class' => 'navbar_right_menu']];
        /*
                if (!$line && !is_array($year)) {
                    $y = '/todo-time/' . $todo_type . '-' . $year . '-' . $todo_status . '/line';
                    $name = 'Линейный график';
                } elseif (!is_array($year)) {
                    $y = '/todo-time/' . $todo_type . '-' . $year . '-' . $todo_status;
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
        /*
        } else {
            $y = '#';
            $name = '#';
        }
        // убрать условие (!is_array($year)) если надо добавить кнопку линейного графика на странице мультивыбор по годам
        if (!is_array($year)) {
            $menu_years_item[] = '<li class="batton_position_8"> <p><a class="btn btn-default btn-lg" href="' . $y . '">' . $name . '</a></p></li>';

        }
*/
        // "<li class='batton_position_1'><p ><a class='btn btn-default btn-lg' href='$url_total'> График общий </a></p></li>"
        return $menu_years_item;
    }

    private function getMenuStatusTodo($todo_type = 1, $year = 2010)
    {
        $menu_status_array = array();
        foreach (Yii::$app->params['todo_status_for_time'] as $k => $v) {
            $name = $v['name'];
            $parent = $v['parent'];
            if ($k == $v['parent']) {

                $r_color = $v['color'][0];
                $g_color = $v['color'][1];
                $b_color = $v['color'][2];

                $menu_status_array[$parent][$k] = ['label' => "$name", 'url' => "/todo-time/$todo_type-$year-$k", "options" => ["id" => "$k", "style" => "background-color: rgb( $r_color,$g_color,$b_color)"], 'active' => ("/todo-time/$todo_type-$year-$k" == Yii::$app->request->url || "/todo-time/$todo_type-$year-$k/line" == Yii::$app->request->url || "/todo-time/$todo_type-$year-$k/two-columns" == Yii::$app->request->url)];
            } else {
                $menu_status_array[$parent][$k] = ['label' => "$name", 'url' => "/todo-time/$todo_type-$year-$k", "options" => ["id" => "$k"], 'active' => ("/todo-time/$todo_type-$year-$k" == Yii::$app->request->url || "/todo-time/$todo_type-$year-$k/line" == Yii::$app->request->url || "/todo-time/$todo_type-$year-$k/two-columns" == Yii::$app->request->url)];
            }

        }
        return $menu_status_array;
    }


    private function noDataRedirect()
    {
        $url = Yii::$app->request->url;


        $url_array = explode('/', $url);
        $param_array = explode("-", $url_array[2]);

        if ($url_array[2] == 'select-data' || $url_array[2] == 'multi-years') {

            return 1;
        }

        if (isset($param_array[1])) {
            $date_request = $param_array[1] . '-01';
            $date_request_timestamp = Yii::$app->formatter->asTimestamp($date_request);
            //$date_now_timestamp = Yii::$app->formatter->asTimestamp('now');
            $date_now = Yii::$app->formatter->asDate('now', 'yyyy') . '-01';
            $date_now_timestamp = Yii::$app->formatter->asTimestamp($date_now);
            $date_before = Yii::$app->params['date-before-todo'];
            $date_before_array = explode("-", $date_before);
            $date_before = $date_before_array[0] . '-01';
            $date_before_timestamp = Yii::$app->formatter->asTimestamp($date_before);
        } else {
            return null;
        }
        if (($date_request_timestamp < $date_before_timestamp) || ($date_request_timestamp > $date_now_timestamp)) {


            // $this->redirect('/charges/no-data');
            //exit();
            header('Location: /todo/no-data');
            exit;
        }
        return null;

    }

    public function actionTodoTimeYear()
    {
        $this->noDataRedirect();

        $url_array = explode("/", Yii::$app->request->url);
        $param_array = explode("-", $url_array[2]);
        // print_r($param_array);
        $year_start_array = str_split($param_array[1], 2);
        $start_period = $year_start_array[1] . '01';

        $end_period = $year_start_array[1] < 9 ? '0' . ($year_start_array[1] + 1) . '01' : $year_start_array[1] + 1 . '01';

        $todo_type = Yii::$app->params['todo_type'][$param_array[0]];//$this->todoType($param_array[0]);

        $todo_status_array = Yii::$app->params['todo_status_for_time'];

        $todo_status = $todo_status_array[$param_array[2]];

        $todoTimeModel = new TodoTime();

        $label = $todoTimeModel->attributeLabels();
        // $label_disconnection = $todoModel->attributeLabelsDisconnection();

        $graph_name = 'Среднее время обработки TODO. ' . $todo_type['name'] . ', ' . $todo_status['name'] . ', ' . $param_array[1] . ' год';
        $chart_name_year = 'charges_by_network_all';


        if (isset($url_array[3]) && $url_array[3] == 'line') {
            $data_year = $this->todoData($todoModel, "Ymd", $start_period, $end_period, $todo_type, 1);
            if (empty($data_year['data'])) {
                header("Location: /todo/$url_array[2]/no-data-in-request");
                exit;
            }

            $graph_type = 1;
            $max_y_scale = max($data_year['data_todo_full']) < 10 ? 10 : (max($data_year['data_todo_full']) + 5);

            $this->chartCreater2($todo_type['name_file'], $graph_name, $data_year['data_todo_full'], $data_year['data_time_full'], 'Количество заявок', 'Дата', 'Y-m-d', $max_y_scale, 90, Yii::$app->params['colors_todo'][$param_array[0]], 7);

        } else {

            $data_year = $this->todoTimeData($todoTimeModel, "Ym", $start_period, $end_period, $todo_type, $todo_status['data_id']);
            // Debugger::PrintR($data_year);


            if (empty($data_year['data'])) {
                header("Location: /todo-time/$url_array[2]/no-data-in-request");
                exit;
            }

            $max_y_scale_left = max($data_year['data_todo']) < 100 ? 100 : (max($data_year['data_todo']) + 25);
            $max_y_scale_right = max($data_year['data_hours']) < 200 ? 200 : (max($data_year['hours_todo']) + 15);
            $text_angle = count($data_year['data_time']) < 15 ? 0 : 90;

            $month_number = count($data_year['data_time']);
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
                    if (isset($data_year['data_time'][$i]) && $data_year['data_time'][$i] == $d) {
                        $d_y['data_time'][$i] = $d;
                        $d_y['data_todo'][$i] = $data_year['data_todo'][$i];
                    } else {
                        $d_y['data_time'][$i] = $d;
                        $d_y['data_todo'][$i] = '';
                    }
                }
                $d_y['data'] = $data_year['data'];

                $data_year = $d_y;
                // print_r($data_year);
            }
            //print_r($data_year);
            // Debugger::PrintR($data_year);

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
            $graph_type = 1;
            if (isset($url_array[3]) && $url_array[3] == 'two-columns') {
                $graph_type = 2;
            }

            $this->chartCreater1($todo_type['name_file'], $graph_name, 'Y-m', $data_year['data_hours'], $data_year['data_todo'], $data_year['data_time'], 'Количество заявок', 'Средне время обработки ТОДО, час', 'Дата', $max_y_scale_right, $max_y_scale_left, $text_angle, Yii::$app->params['todo_time_color'],1, $graph_type);
        }


        $line = 0;
        if (isset($url_array[3])) {
            if ($url_array[3] == 'table') {

                $views_name = 'todo_time_table';
            } elseif ($url_array[3] == 'line') {
                $views_name = 'todo_year';
                $line = 1;
            } elseif ($url_array[3] == 'two-columns') {
                $views_name = 'todo_time_year';
            } else {
                throw new Exception('Страница не найдена');
            }
        } else {
            $views_name = 'todo_time_year';
        }

        return $this->render($views_name, [
            'label' => $label,
            'chart_name_year' => $chart_name_year,
            'data' => $data_year['data_dif'],
            'year' => $param_array[1],
            'todo_type' => $param_array[0],
            'todo_status' => $param_array[2],
            'todo_status_name' => $todo_status['name'],
            'todo_status_array' => $todo_status_array,
            'name' => $todo_type['name'],
            'name_file' => $todo_type['name_file'],
            'menu_items_years' => $this->getMenuItemsYears($param_array[0], $param_array[2], $param_array[1], $line),
            'line' => $line,
            'graph_type' => $graph_type,
            'menu_status_todo' => $this->getMenuStatusTodo($param_array[0], $param_array[1]),


        ]);
    }


    private function todoTimeData(TodoTime $todoTimeModel, $format, $start_period, $end_period, $todo_type, $todo_status)
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

        $data = $todoTimeModel->TodoSelect($start_period, $end_period, $todo_type['type_id'], $todo_status);
//Debugger::PrintR($data);
        // Debugger::testDie();

        //   $todo_status_data = Yii::$app->params['todo_status'];


        //  Debugger::PrintR($todo_status_data);

        /*
                if ($todo_status) {
                    foreach ($data as $k => $v) {
                        if (!isset($todo_status_data[$todo_status]['data'][$v['todo_state']])) {
                            unset($data[$k]);
                        }
                    }
                }
        */
        // Debugger::PrintR($data);
        //Debugger::testDie();
        $total_data = array();
        $data_array_dif = array();
        $data_tm = array();
        $data_count = array();
        $data_hours = array();

        $n_e_p = strlen($end_period) % 2 ? '0' . $end_period : $end_period;
        $n_s_p = strlen($start_period) % 2 ? '0' . $start_period : $start_period;

        $s_p_array = str_split($n_s_p, 2);
        $e_p_array = str_split($n_e_p, 2);

        $index = ((int)$e_p_array[0] - (int)$s_p_array[0]) > 1 ? 0 : 1;
        for ($i = $s_p_array[0]; $i <= ($e_p_array[0] - $index); $i++) {

            $i = (int)$i;
            $data_array_dif[$i] = array();
            if ($format == 'Ym') {
                if ($i != $e_p_array[0] && $i != $s_p_array[0]) {
                    for ($i_m = 1; $i_m < 13; $i_m++) {
                        $data_array_dif[$i][$i_m] = array();

                    }
                } elseif ($i == $e_p_array[0]) {
                    for ($i_m = 1; $i_m <= (int)$e_p_array[1]; $i_m++) {
                        $data_array_dif[$i][$i_m] = array();

                    }
                } elseif ($i == $s_p_array[0]) {
                    for ($i_m = (int)$s_p_array[1]; $i_m < 13; $i_m++) {
                        $data_array_dif[$i][$i_m] = array();

                    }
                }
            }

            foreach ($data as $k => $v) {
                if ($v['sum_hour'] >= 0) {  // удаление некорректных данный у которых нет времени изменения и сумма часов меньше 0
                    $n = strlen($v['ts']) % 2 ? '0' . $v['ts'] : $v['ts'];
                    $data[$k]['date_array'] = str_split($n, 2);
                } else {
                    unset($data[$k]);
                }
            }


            if ($format == 'Ym') {
                foreach ($data as $k => $v) {

                    $data_array_dif[(int)$v['date_array'][0]][(int)$v['date_array'][1]][] = $v;
                }
            }
        }


        if ($format == 'Ym') {
            foreach ($data_array_dif as $k => $v) {
                foreach ($v as $key => $val) {
                    $sum_time = 0;
                    foreach ($val as $k_item => $v_item) {
                        $sum_time += $v_item['sum_hour'];

                    }
                    $count = count($val);

                    if ($key != 10 && $key != 11 && $key != 12) {
                        $data_tm[] = $this->dateParsing($k . '0' . $key);
                        $data_array_dif[$k][$key]['time'] = $k . '0' . $key;
                    } else {
                        $data_tm[] = $this->dateParsing($k . $key);
                        $data_array_dif[$k][$key]['time'] = $k . $key;
                    }

                    $data_count[] = $count;
                    $data_array_dif[$k][$key]['count'] = $count;
                    $sum_time = $sum_time > 0 ? $sum_time : 0;
                    $average_time = $count != 0 ? round($sum_time / $count, 1) : 0;
                    $data_hours[] = $average_time;
                    $data_array_dif[$k][$key]['average_hours'] = $average_time;

                }
            }
        }

        $total_data['data_dif'] = $data_array_dif;
        $total_data['data_hours'] = $data_hours;
        $total_data['data_time'] = $data_tm;
        $total_data['data_todo'] = $data_count;
        $total_data['data'] = $data;

        if ($format == 'Ym' && ((int)$end_period - (int)$start_period) <= 100) { //для графика по месяцам обрезает возникшие не корректные данные возникшие из-за ошибок в беза
            // данных.Появление хотяб одного некорректоно данного может привести к появлению 13 столбца в графике (вместо 12)
            foreach ($total_data as $k => $v) {
                if (strpos($k, '_time') || strpos($k, '_todo')) {
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


        //Debugger::PrintR($total_data['data_hours']);
        //Debugger::testDie();

        return $total_data;
    }


    public function actionTodoTimeTable()
    {
        //  $this->noDataRedirect();

        $url_get_array = explode("?", Yii::$app->request->url);

        $url_a = explode("/", $url_get_array[0]);

        $param_a = explode("-", $url_a[2]);

        $n = count($param_a);


        if ($n == 3) {
            return $this->actionTodoTimeYear();
        } elseif ($n == 2 && $url_a[2] != 'select-data' && $url_a[2] != 'multi-years') {

            return $this->actionTodoQuantityYear();
        } elseif (isset($url_a[2]) && $url_a[2] == 'select-data' && $url_a[3] == 'table') {


            return $this->actionSelectData(Yii::$app->request->get('year_start'), Yii::$app->request->get('year_end'), Yii::$app->request->get('todo_type'), Yii::$app->request->get('todo_status'));

        } elseif (isset($url_a[2]) && $url_a[2] == 'select-data' && $url_a[3] != 'table') {


            return $this->actionSelectData(Yii::$app->request->get('year_start'), Yii::$app->request->get('year_end'), Yii::$app->request->get('todo_type'));
        } elseif ($n == 1 && $param_a[0] > 0 && $param_a[0] <= 6 && $url_a[3] == 'table') {
            return $this->actionTodoQuantityAll();
        } elseif ($n == 1 && $url_a[4] == 'table') {
            return $this->actionChargesMultiYear();


        } elseif ($n == 2 && $url_a[2] == 'multi-years') {

            return $this->actionSelectDataMultiYears(Yii::$app->request->get('years'), Yii::$app->request->get('user_type'));
        } else {
            return null;
        }
    }


    public function actionSelectData($year_start_table = null, $year_end_table = null, $todo_type_table = null, $todo_status_table = null)
    {


        $todoTimeModel = new TodoTime();
        $modelTodoTimeForm = new TodoTimeForm();


        $u = explode('?', Yii::$app->request->url);

        $url_array = explode("/", $u[0]);

        $label = $todoTimeModel->attributeLabels();
        $date_today = Yii::$app->formatter->asDate('now', 'yyyy');

        $todo_type_id = Yii::$app->params["default_value"]["todo_time"]["year_todo_type"];
        $todo_type = Yii::$app->params['todo_type'][$todo_type_id];
        $start_year = ($date_today - 1999) - Yii::$app->params['year-period-select-todo-time'];
        $end_year = ($date_today - 1999);
        $start_period = $start_year . '01';
        $end_period = ($end_year) . '01';

        $todo_status_array = Yii::$app->params['todo_status_for_time'];

        $todo_status_id = Yii::$app->params["default_value"]["todo_time"]["year_todo_status"];

        $todo_status = $todo_status_array[$todo_status_id];

        if (Yii::$app->request->post()) {
            if (Yii::$app->request->post('TodoTimeForm')['year_from'] <= Yii::$app->request->post('TodoTimeForm')['year_to']) {
                $todo_t = Yii::$app->request->post('TodoTimeForm')['todo_type'];
                $todo_type = Yii::$app->params['todo_type'][$todo_t];
                $start_p = Yii::$app->request->post('TodoTimeForm')['year_from'];
                $end_p = (Yii::$app->request->post('TodoTimeForm')['year_to'] + 1);
                $todo_st = Yii::$app->request->post('TodoTimeForm')['todo_status'];

                $modelTodoTimeForm->year_to = ($end_p - 1);
                $modelTodoTimeForm->year_from = $start_p;
                $modelTodoTimeForm->todo_type = $todo_t;
                $modelTodoTimeForm->todo_status = $todo_st;

            } else {
                Yii::$app->session->addFlash('dateHight', 'Дата начала приода должна быть меньше даты окончания периода! Введите данные еще раз.');

            }

        }


        if (isset($start_p) && isset($end_p) && isset($todo_t) && isset($todo_st)) {

            $todo_type = Yii::$app->params['todo_type'][$todo_t];
            $start_year = $start_p;
            $end_year = $end_p;

            $start_period = $start_year . '01';
            $end_period = $end_year . '01';
            $todo_status = $todo_status_array[$todo_st];

        }

        if (isset($year_start_table) && isset($year_end_table) && isset($todo_type_table)) {

            $todo_type = Yii::$app->params['todo_type'][$todo_type_table];
            $start_year = round($year_start_table / 100);
//Debugger::Eho($start_year);
            //    Debugger::testDie();
            $end_year = round($year_end_table / 100);

            $start_period = $year_start_table;
            $end_period = $year_end_table;
            $todo_status = $todo_status_array[$todo_status_table];
            //  $todo_type_array = Yii::$app->params['todo_type'][$todo_type];
        }

        $data_year = $this->todoTimeData($todoTimeModel, "Ym", $start_period, $end_period, $todo_type, $todo_status['data_id']);

        if (empty($data_year['data'])) {
            header("Location: /todo-time/$url_array[2]/no-data-in-request");
            exit;
        }

        $max_y_scale_left = max($data_year['data_todo']) < 100 ? 100 : (max($data_year['data_todo']) + 25);
        $max_y_scale_right = max($data_year['data_hours']) < 200 ? 200 : (max($data_year['hours_todo']) + 15);
        $text_angle = count($data_year['data_time']) < 15 ? 0 : 90;

        $graph_name = 'Среднее время обработки TODO. ' . $todo_type['name'] . ', ' . $todo_status['name'] . ', за период ' . ($start_year + 2000) . ' - ' . ($end_year + 1999) . ' год';


        if (($end_period - $start_period) > 100) {
            array_pop($data_year['data_todo']); //удаление последнего пустого значения
            array_pop($data_year['data_hours']);//удаление последнего пустого значения
            array_pop($data_year['data_time']); //удаление последнего пустого значения
        }
        $graph_type = 1;
        if (isset($url_array[3]) && $url_array[3] == 'two-columns') {

            $graph_type = 2;
        }

        $this->chartCreater1($todo_type['name_file'], $graph_name, 'Y-m', $data_year['data_hours'], $data_year['data_todo'], $data_year['data_time'], 'Количество заявок', 'Средне время обработки ТОДО, час', 'Дата', $max_y_scale_right, $max_y_scale_left, $text_angle, Yii::$app->params['todo_time_color'],1, $graph_type);


        $line = 0;
        if (isset($url_array[3])) {
            if ($url_array[3] == 'table') {

                $views_name = 'todo_time_table';
            } elseif ($url_array[3] == 'line') {
                $views_name = 'todo_year';
                $line = 1;
            } elseif ($url_array[3] == 'two-columns') {
                $views_name = 'select-data-time';
            } else {
                throw new Exception('Страница не найдена');
            }
        } else {
            $views_name = 'select-data-time';
        }


        $years_array = array();
        for ($i = 2008; $i <= ((int)$date_today); $i++) {
            $years_array[$i - 2000] = $i;
        }
        $todo_type_a = array();
        for ($i = 1; $i <= 6; $i++) {
            $todo_type_a[$i] = $this->todoType($i)['name'];
        }


        $todo_status_array_dif = $this->getMenuStatusTodo();
        $todo_status_a = array();
        foreach ($todo_status_array_dif as $k => $v) {
            $title_label_2 = str_replace('Все(', '', $v[$k]['label']);
            $title_label = str_replace(')', '', $title_label_2);
            $title_label = mb_strtoupper($title_label);
            $todo_status_a[$title_label] = array();
            foreach ($v as $key => $val) {
                $todo_status_a[$title_label][$key] = $val['label'];
            }
        }

        $chart_name_year = 'charges_by_network_all';
        $todo_status_name = $todo_status['name'];

        if (count($data_year['data_dif']) > 1) {
            array_pop($data_year['data_dif']);
        }


        return $this->render($views_name, [
            'label' => $label,
            'chart_name_year' => $chart_name_year,
            'data' => $data_year['data_dif'],
            'todo_type' => $todo_type_id,
            'name' => $todo_type['name'],
            'name_file' => $todo_type['name_file'],
            'start_period' => $start_period,
            'end_period' => $end_period,
            'start_year' => $start_year,
            'end_year' => $end_year,
            'model_todo_form' => $modelTodoTimeForm,
            'years_array' => $years_array,
            'todo_type_a' => $todo_type_a,
            'todo_status_a' => $todo_status_a,
            'todo_status' => $todo_status_id,
            'todo_status_name' => $todo_status_name,
            'graph_type' => $graph_type,
        ]);
    }


}