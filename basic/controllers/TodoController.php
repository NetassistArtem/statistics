<?php


namespace app\controllers;


use app\components\debugger\Debugger;
use app\controllers\StatisticsController;
use app\models\Todo;
use app\models\TodoForm;
use yii\web\Controller;
use app;
use Yii;
use yii\base\Exception;

class TodoController extends Controller
{


    private function chartCreater1($file_name, $chart_name, $data_y, $data_x, $name_y, $name_x, $date_format, $max_YAxis, $text_angle_X, array $color_pallet, $x_interval = 1)
    {
        include_once(__DIR__ . '/../vendor/pChart/pChart/pData.class');
        include_once(__DIR__ . '/../vendor/pChart/pChart/pChart.class');

        // Dataset definition
        $DataSet = new \pData;
        $DataSet->SetXAxisFormat("date");
        $DataSet->AddPoint($data_x, "series_1");
        $DataSet->AddPoint($data_y, "series_2");
        $DataSet->AddSerie("series_2");
        $DataSet->SetAbsciseLabelSerie("series_1");
        //$DataSet->SetSerieName("January","Serie1");
        //$DataSet->SetSerieName("February","Serie2");
        $DataSet->SetYAxisName($name_y);
        $DataSet->SetXAxisName($name_x);

        // Initialise the graph
        $Test = new \pChart(1170, 545);
        $Test->setColorPalette(0, $color_pallet[0], $color_pallet[1], $color_pallet[2]);
        $Test->setFixedScale(0, $max_YAxis, 10);
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
        $Test->drawOverlayBarGraph($DataSet->GetData(), $DataSet->GetDataDescription());

        // Write values
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 12);
        $Test->writeValues($DataSet->GetData(), $DataSet->GetDataDescription(), "series_2");

        // Finish the graph
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 8);
        // $Test->drawLegend(600,30,$DataSet->GetDataDescription(),255,255,255);
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 10);
        $Test->drawTitle(550, 22, $chart_name, 50, 50, 50, 585);
        $Test->Render(__DIR__ . '/../web/images/' . $file_name . '.png');
    }

    private function chartCreater2($file_name, $chart_name, $data_y, $data_x, $name_y, $name_x, $date_format, $max_YAxis, $text_angle_X, array $color_pallet, $x_interval = 1)
    {
        include_once(__DIR__ . '/../vendor/pChart/pChart/pData.class');
        include_once(__DIR__ . '/../vendor/pChart/pChart/pChart.class');

        // Dataset definition
        $DataSet = new \pData;
        $DataSet->SetXAxisFormat("date");
        $DataSet->AddPoint($data_x, "series_1");
        $DataSet->AddPoint($data_y, "series_2");
        $DataSet->AddSerie("series_2");
        $DataSet->SetAbsciseLabelSerie("series_1");
        //$DataSet->SetSerieName("January","Serie1");
        //$DataSet->SetSerieName("February","Serie2");
        $DataSet->SetYAxisName($name_y);
        $DataSet->SetXAxisName($name_x);

        // Initialise the graph
        $Test = new \pChart(1170, 545);
        $Test->setColorPalette(0, $color_pallet[0], $color_pallet[1], $color_pallet[2]);
        $Test->setFixedScale(0, $max_YAxis, 10);
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

        // Draw the cubic curve graph
        $Test->drawCubicCurve($DataSet->GetData(), $DataSet->GetDataDescription());

        // Finish the graph
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 8);
        // $Test->drawLegend(600,30,$DataSet->GetDataDescription(),255,255,255);
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 10);
        $Test->drawTitle(550, 22, $chart_name, 50, 50, 50, 585);
        $Test->Render(__DIR__ . '/../web/images/' . $file_name . '.png');
    }


    private function chartCreater3($file_name, $chart_name, $data_array_y, $data_x, $name_y, $name_x, $date_format, $max_YAxis, $text_angle_X, array $color_pallet, $x_interval = 1)
    {
        include_once(__DIR__ . '/../vendor/pChart/pChart/pData.class');
        include_once(__DIR__ . '/../vendor/pChart/pChart/pChart.class');

        // Dataset definition
        $DataSet = new \pData;
        $DataSet->SetXAxisFormat("date");
        foreach ($data_array_y as $k => $v) {
            $DataSet->AddPoint($v, "series_{$k}");
            $DataSet->AddSerie("series_{$k}");
        }

        $DataSet->AddPoint($data_x, "series_1");


        $DataSet->SetAbsciseLabelSerie("series_1");
        //$DataSet->SetSerieName("January","Serie1");
        //$DataSet->SetSerieName("February","Serie2");
        $DataSet->SetYAxisName($name_y);
        $DataSet->SetXAxisName($name_x);

        $todo_status_array = array_reverse(Yii::$app->params['todo_status']);

        // Initialise the graph
        $Test = new \pChart(1170, 545);
        $Test->setColorPalette(0, $color_pallet[0], $color_pallet[1], $color_pallet[2]);
        foreach ($todo_status_array as $k => $v) {
            $Test->setColorPalette($k + 1, $v['color'][0], $v['color'][1], $v['color'][2]);
        }
        $Test->setFixedScale(0, $max_YAxis, 10);
        $Test->setDateFormat($date_format);
        //$Test->setFixedScale(0,4200,200);

        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 8);
        $Test->setGraphArea(70, 30, 1120, 450);
        $Test->drawFilledRoundedRectangle(7, 7, 1163, 538, 5, 240, 240, 240);
        $Test->drawRoundedRectangle(5, 5, 1165, 540, 5, 230, 230, 230);
        $Test->drawGraphArea(255, 255, 255, TRUE);
        $Test->drawScale($DataSet->GetData(), $DataSet->GetDataDescription(), SCALE_ADDALL, 0, 0, 0, TRUE, $text_angle_X, 0, TRUE, $x_interval);
        $Test->drawGrid(4, TRUE, 230, 230, 230, 50);

        // Draw the 0 line
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 6);
        $Test->drawTreshold(0, 143, 55, 72, TRUE, TRUE);


        // Draw the bar graph

        $DataSet->RemoveSerie("series_data");
        $DataSet->SetSerieName('Сумма', "series_data");

        foreach ($todo_status_array as $v) {
            $n_e = $v['name_en'];
            $DataSet->SetSerieName($v['name'], "series_{$n_e}");
        }


        $Test->drawStackedBarGraph($DataSet->GetData(), $DataSet->GetDataDescription(), 50, FALSE);

        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 10);

        if ($file_name != 'todo_disconnecting') {
            $Test->drawLegend(75, 35, $DataSet->GetDataDescription(), 255, 255, 255);
        }

        foreach ($data_array_y as $k => $v) {
            if ($k != 'data') {
                $DataSet->RemoveSerie("series_{$k}");
            }
        }
        $DataSet->AddSerie("series_data");
        $Test->drawOverlayBarGraph($DataSet->GetData(), $DataSet->GetDataDescription());

        // Write values
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 12);


        $Test->writeValues($DataSet->GetData(), $DataSet->GetDataDescription(), "series_data");
        // Finish the graph

        // $Test->drawLegend(600,30,$DataSet->GetDataDescription(),255,255,255);
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 10);
        $Test->drawTitle(550, 22, $chart_name, 50, 50, 50, 585);
        $Test->Render(__DIR__ . '/../web/images/' . $file_name . '.png');
    }


    private function chartCreater4($file_name, $chart_name, $data_array_y, $data_x, $name_y, $name_x, $date_format, $max_YAxis, $text_angle_X, array $color_pallet, $x_interval = 1)
    {
        include_once(__DIR__ . '/../vendor/pChart/pChart/pData.class');
        include_once(__DIR__ . '/../vendor/pChart/pChart/pChart.class');

        // Dataset definition
        $DataSet = new \pData;
        $DataSet->SetXAxisFormat("date");
        foreach ($data_array_y as $k => $v) {
            $DataSet->AddPoint($v, "series_{$k}");
            $DataSet->AddSerie("series_{$k}");
        }


        $DataSet->AddPoint($data_x, "series_1");
        $DataSet->SetAbsciseLabelSerie("series_1");
        //$DataSet->SetSerieName("January","Serie1");
        //$DataSet->SetSerieName("February","Serie2");
        $DataSet->SetYAxisName($name_y);
        $DataSet->SetXAxisName($name_x);

        $todo_status_array = array_reverse(Yii::$app->params['todo_status']);

        // Initialise the graph
        $Test = new \pChart(1170, 545);
        $Test->setColorPalette(0, $color_pallet[0], $color_pallet[1], $color_pallet[2]);
        foreach ($todo_status_array as $k => $v) {
            $Test->setColorPalette($k + 1, $v['color'][0], $v['color'][1], $v['color'][2]);
        }
        $Test->setFixedScale(0, $max_YAxis, 10);
        $Test->setDateFormat($date_format);
        //$Test->setFixedScale(0,4200,200);

        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 8);
        $Test->setGraphArea(70, 30, 1120, 450);
        $Test->drawFilledRoundedRectangle(7, 7, 1163, 538, 5, 240, 240, 240);
        $Test->drawRoundedRectangle(5, 5, 1165, 540, 5, 230, 230, 230);
        $Test->drawGraphArea(255, 255, 255, TRUE);

        $Test->drawScale($DataSet->GetData(), $DataSet->GetDataDescription(), SCALE_ADDALL, 0, 0, 0, TRUE, $text_angle_X, 0, TRUE, $x_interval);
        $Test->drawGrid(4, TRUE, 230, 230, 230, 50);

        // Draw the 0 line
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 6);
        $Test->drawTreshold(0, 143, 55, 72, TRUE, TRUE);

        // Draw the bar graph
        $DataSet->RemoveSerie("series_data");
        $DataSet->SetSerieName('Сумма', "series_data");

        foreach ($todo_status_array as $v) {
            $n_e = $v['name_en'];
            $DataSet->SetSerieName($v['name'], "series_{$n_e}");
        }

        $Test->drawStackedBarGraph($DataSet->GetData(), $DataSet->GetDataDescription(), 50, FALSE);

        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 10);

        if ($file_name != 'todo_disconnecting') {
            $Test->drawLegend(75, 35, $DataSet->GetDataDescription(), 255, 255, 255);
        }

        foreach ($data_array_y as $k => $v) {
            if ($k != 'data') {
                $DataSet->RemoveSerie("series_{$k}");
            }
        }
        $DataSet->AddSerie("series_data");
        $Test->drawOverlayBarGraph($DataSet->GetData(), $DataSet->GetDataDescription());

        // Write values
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 12);
        $Test->writeValues($DataSet->GetData(), $DataSet->GetDataDescription(), "series_data");

        // Finish the graph
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 8);
        // $Test->drawLegend(600,30,$DataSet->GetDataDescription(),255,255,255);
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 10);
        $Test->drawTitle(550, 22, $chart_name, 50, 50, 50, 585);
        $Test->Render(__DIR__ . '/../web/images/' . $file_name . '.png');
    }


    private function chartCreater5($file_name, $chart_name, $data_y, $data_x, $name_y, $name_x, $date_format, $max_YAxis, $text_angle_X, array $color_pallet, $x_interval = 1)
    {                             // $file_name, $chart_name, $data_y, $data_x, $name_y, $name_x, $date_format, $max_YAxis, $text_angle_X, array $color_pallet, $x_interval = 1
        include_once(__DIR__ . '/../vendor/pChart/pChart/pData.class');
        include_once(__DIR__ . '/../vendor/pChart/pChart/pChart.class');

        // Dataset definition
        $DataSet = new \pData;
        $DataSet->SetXAxisFormat("date");
        $DataSet->AddPoint($data_x, "series_1");
        $DataSet->AddPoint($data_y, "series_2");
        // $DataSet->ImportFromCSV(__DIR__ . '/../vendor/pChart/Sample/bulkdata.csv',",",array(1,2,3),FALSE,0);
        $DataSet->AddSerie("series_2");
        $DataSet->SetAbsciseLabelSerie("series_1");
        //  $DataSet->SetSerieName("January","Serie1");
        //$DataSet->SetSerieName("February","Serie2");
        // $DataSet->SetSerieName("March","Serie3");
        $DataSet->SetYAxisName($name_y);
        $DataSet->SetXAxisName($name_x);


        // Initialise the graph
        $Test = new \pChart(1170, 545);
        $Test->setColorPalette(0, $color_pallet[0], $color_pallet[1], $color_pallet[2]);
        $Test->setDateFormat($date_format);
        $Test->setFixedScale(0, $max_YAxis, 10);
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 8);
        $Test->setGraphArea(70, 30, 1120, 450);
        $Test->drawFilledRoundedRectangle(7, 7, 1163, 538, 5, 240, 240, 240);
        $Test->drawRoundedRectangle(5, 5, 1165, 540, 5, 230, 230, 230);
        $Test->drawGraphArea(255, 255, 255, TRUE);
        $Test->drawScale($DataSet->GetData(), $DataSet->GetDataDescription(), SCALE_NORMAL, 150, 150, 150, TRUE, $text_angle_X, 0, TRUE, $x_interval);
        $Test->drawGrid(4, TRUE, 230, 230, 230, 50);

        // Draw the 0 line
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 6);
        $Test->drawTreshold(0, 143, 55, 72, TRUE, TRUE);

        // Draw the line graph

        $Test->drawLineGraph($DataSet->GetData(), $DataSet->GetDataDescription());
        $Test->drawPlotGraph($DataSet->GetData(), $DataSet->GetDataDescription(), 3, 2, 255, 255, 255);

        // Write values
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 12);
        $Test->writeValues($DataSet->GetData(), $DataSet->GetDataDescription(), "series_2");

        // Finish the graph
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 8);
        // $Test->drawLegend(75,35,$DataSet->GetDataDescription(),255,255,255);
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 10);
        $Test->drawTitle(550, 22, $chart_name, 50, 50, 50, 585);
        $Test->Render(__DIR__ . '/../web/images/' . $file_name . '.png');

    }


    private function cssColumnPosition($number_column)
    {
        $one_column_with_marg = 89.64 / ($number_column);
        $two_marg = $one_column_with_marg * 0.4685;
        $one_marg = $two_marg / 2;
        $column_w = $one_column_with_marg - $two_marg;
        $marg_left = 6.067;
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
            $date_before = Yii::$app->params['date-before-todo'];
            $date_before_array = explode("-", $date_before);
            $date_before = $date_before_array[0] . '-' . $date_before_array[1];
            $date_before_timestamp = Yii::$app->formatter->asTimestamp($date_before);
        } elseif (isset($param_array[1])) {
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


    private function getMenuItemsYears($todo_type, $year = 0, $line = 0)
    {
        $menu_years_item = array();
        for ($i = 2008; $i <= Yii::$app->formatter->asDate(time(), 'Y'); $i++) {
            $menu_years_item[] = ['label' => "$i", 'url' => "/todo/$todo_type-$i", "options" => ["id" => "$i"], 'active' => ("/todo/$todo_type-$i" == Yii::$app->request->url || "/todo/$todo_type-$i/line" == Yii::$app->request->url) ||
                strpos(Yii::$app->request->url, (string)$i)];

        }
        //   $menu_years_item[] = ['label' => "Таблица данных", 'url' => Yii::$app->request->url.'/table','options' => ['class' => 'navbar_right_menu']];

        if (!$line && !is_array($year)) {
            $y = '/todo/' . $todo_type . '-' . $year . '/line';
            $name = 'Линейный график';
        } elseif (!is_array($year)) {
            $y = '/todo/' . $todo_type . '-' . $year;
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
        } else {
            $y = '#';
            $name = '#';
        }
        // убрать условие (!is_array($year)) если надо добавить кнопку линейного графика на странице мультивыбор по годам
        if (!is_array($year)) {
            $menu_years_item[] = '<li class="batton_position_8"> <p><a class="btn btn-default btn-lg" href="' . $y . '">' . $name . '</a></p></li>';

        }

        // "<li class='batton_position_1'><p ><a class='btn btn-default btn-lg' href='$url_total'> График общий </a></p></li>"
        return $menu_years_item;
    }

    private function getMenuItemsMonth($todo_type, $year, $month, $line = 0)
    {
        $menu_month_item = array();
        for ($i = 1; $i <= 12; $i++) {

            $i_text = $i < 10 ? '0' . $i : $i;
            $menu_month_item[] = ['label' => "$i_text", 'url' => "/todo/$todo_type-$year-$i_text", 'active' => ("/todo/$todo_type-$year-$i_text" == Yii::$app->request->url || "/todo/$todo_type-$year-$i_text/line" == Yii::$app->request->url)];
        }

        if (!$line) {
            $y = '/todo/' . $todo_type . '-' . $year . '-' . $month . '/line';
            $name = 'Линейный график';
        } else {
            $y = '/todo/' . $todo_type . '-' . $year . '-' . $month;
            $name = 'Столбцовый график';
        }

        $menu_month_item[] = '<li class="batton_position_7"> <p><a class="btn btn-default btn-lg" href="' . $y . '">' . $name . '</a></p></li>';

        return $menu_month_item;
    }


    public function actionTodoQuantityAll()
    {

        $url_array = explode("/", Yii::$app->request->url);
        $param_array = explode("-", $url_array[2]);

        $date_start_array = explode("-", Yii::$app->params['date-before-todo']);
        $start_period = str_split($date_start_array[0], 2)[1];


        $end_period = Yii::$app->formatter->asDate('now', 'yy');
        $end_period = (int)$end_period + 1;

        $todo_type = $this->todoType($param_array[0]);

        $todoModel = new Todo();

        $label = $todoModel->attributeLabels();
        $label_disconnection = $todoModel->attributeLabelsDisconnection();

        $graph_name = $todo_type['name'] . ', весь период.';
        $chart_name_all = 'charges_by_network_all';


        if (isset($url_array[3]) && $url_array[3] == 'line') {
            $start_period_line = $start_period . '01';
            $end_period_line = $end_period . '01';
            $data_all = $this->todoData($todoModel, "Ym", $start_period_line, $end_period_line, $todo_type, 1);

            $max_y_scale = max($data_all['data_todo']) < 300 ? 300 : (max($data_all['data_todo']) + 50);

            $this->chartCreater2($todo_type['name_file'], $graph_name, $data_all['data_todo'], $data_all['data_time'], 'Количество заявок', 'Дата', 'Y-m-d', $max_y_scale, 90, Yii::$app->params['colors_todo'][$param_array[0]], 3);

            $years_number = 0;
            $css_data = 0;
        } else {
            $data_all = $this->todoData($todoModel, "Y", $start_period, $end_period, $todo_type, 1);


            $max_y_scale = max($data_all['data_todo']) < 2000 ? 2000 : (max($data_all['data_todo']) + 150);

            $years_number = count($data_all['data_time']);

            $css_data = $this->cssColumnPosition($years_number);

            //print_r($data_year);
            // Debugger::PrintR($data_year);

            $data_array_y = array();
            if ($param_array[0] != 6) {
                foreach (Yii::$app->params['todo_status'] as $v) {
                    $k = $v['name_en'];
                    $data_array_y[$k] = $data_all["{$k}_todo"];
                }
            }
            $data_array_y['data'] = $data_all['data_todo'];


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


            $this->chartCreater3($todo_type['name_file'], $graph_name, $data_array_y, $data_all['data_time'], 'Количество заявок', 'Дата', 'Y', $max_y_scale, 0, Yii::$app->params['colors_todo'][$param_array[0]]);
        }
        $line = 0;
        if (isset($url_array[3])) {
            if ($url_array[3] == 'table' && $param_array[0] != 6) {

                $views_name = 'todo_data_table';
            } elseif ($url_array[3] == 'table' && $param_array[0] == 6) {
                $views_name = 'todo_data_disconnections_table';
            } elseif ($url_array[3] == 'line') {
                $views_name = 'todo_all';
                $line = 1;
            } else {
                throw new Exception('Страница не найдена');
            }
        } else {
            $views_name = 'todo_all';
        }


        return $this->render($views_name, [
            'label' => $label,
            'label_disconnection' => $label_disconnection,
            'chart_name_year' => $chart_name_all,
            'data' => $data_all['data'],
            'todo_type' => $param_array[0],
            'name' => $todo_type['name'],
            'name_file' => $todo_type['name_file'],
            'line' => $line,
            'years_number' => $years_number,
            'start_period' => $start_period + 2000,
            'end_period' => $end_period + 2000,
            'css_data' => $css_data
        ]);
    }


    public function actionTodoQuantityYear()
    {
        $this->noDataRedirect();

        $url_array = explode("/", Yii::$app->request->url);
        $param_array = explode("-", $url_array[2]);
        // print_r($param_array);
        $year_start_array = str_split($param_array[1], 2);
        $start_period = $year_start_array[1] . '01';

        $end_period = $year_start_array[1] < 9 ? '0' . ($year_start_array[1] + 1) . '01' : $year_start_array[1] + 1 . '01';

        $todo_type = $this->todoType($param_array[0]);

        $todoModel = new Todo();

        $label = $todoModel->attributeLabels();
        $label_disconnection = $todoModel->attributeLabelsDisconnection();

        $graph_name = $todo_type['name'] . ', ' . $param_array[1] . ' год';
        $chart_name_year = 'charges_by_network_all';


        if (isset($url_array[3]) && $url_array[3] == 'line') {
            $data_year = $this->todoData($todoModel, "Ymd", $start_period, $end_period, $todo_type, 1);
            if (empty($data_year['data'])) {
                header("Location: /todo/$url_array[2]/no-data-in-request");
                exit;
            }


            $max_y_scale = max($data_year['data_todo_full']) < 10 ? 10 : (max($data_year['data_todo_full']) + 5);

            $this->chartCreater2($todo_type['name_file'], $graph_name, $data_year['data_todo_full'], $data_year['data_time_full'], 'Количество заявок', 'Дата', 'Y-m-d', $max_y_scale, 90, Yii::$app->params['colors_todo'][$param_array[0]], 7);

        } else {

            $data_year = $this->todoData($todoModel, "Ym", $start_period, $end_period, $todo_type, 1);

            if (empty($data_year['data'])) {
                header("Location: /todo/$url_array[2]/no-data-in-request");
                exit;
            }

            $max_y_scale = max($data_year['data_todo']) < 200 ? 200 : (max($data_year['data_todo']) + 25);

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

            $data_array_y = array();
            if ($param_array[0] != 6) {
                foreach (Yii::$app->params['todo_status'] as $v) {
                    $k = $v['name_en'];
                    $data_array_y[$k] = $data_year["{$k}_todo"];
                }
            }
            $data_array_y['data'] = $data_year['data_todo'];


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


            $this->chartCreater3($todo_type['name_file'], $graph_name, $data_array_y, $data_year['data_time'], 'Количество заявок', 'Дата', 'Y-m', $max_y_scale, 0, Yii::$app->params['colors_todo'][$param_array[0]]);
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
            $views_name = 'todo_year';
        }


        return $this->render($views_name, [
            'label' => $label,
            'label_disconnection' => $label_disconnection,
            'chart_name_year' => $chart_name_year,
            'data' => $data_year['data'],
            'year' => $param_array[1],
            'todo_type' => $param_array[0],
            'name' => $todo_type['name'],
            'name_file' => $todo_type['name_file'],
            'menu_items_years' => $this->getMenuItemsYears($param_array[0], $param_array[1], $line),
            'line' => $line
        ]);
    }


    public function actionTodoQuantityMonth()
    {

        // $this->redirect('/charges/no-data');

        $this->noDataRedirect();

        $url_array = explode("/", Yii::$app->request->url);

        $param_array = explode("-", $url_array[2]);
        // print_r($param_array);
        $year_start_array = str_split($param_array[1], 2);
        $start_period = $year_start_array[1] . $param_array[2];
        $end_period = $param_array[2] < 9 ? $year_start_array[1] . '0' . ($param_array[2] + 1) : $year_start_array[1] . ($param_array[2] + 1);

        $todo_type = $this->todoType($param_array[0]);

        $todoModel = new Todo();

        $label = $todoModel->attributeLabels();
        $label_disconnection = $todoModel->attributeLabelsDisconnection();


        $chart_name_month = 'todo_by_network_all';

        $graph_name = $todo_type['name'] . ', ' . $param_array[1] . ' год, ' . $param_array[2] . ' месяц';

        if (isset($url_array[3]) && $url_array[3] == 'line') {
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

        } else {
            $data_month = $this->todoData($todoModel, "Ymd", $start_period, $end_period, $todo_type, 1);
            if (empty($data_month['data'])) {
                header("Location: /todo/$url_array[2]/no-data-in-request");
                exit;
            }

            $max_y_scale = max($data_month['data_todo']) < 20 ? 20 : (max($data_month['data_todo']) + 5);


            $text_angle = count($data_month['data_todo']) < 15 ? 0 : 90;

            $data_array_y = array();
            if ($param_array[0] != 6) {
                foreach (Yii::$app->params['todo_status'] as $v) {
                    $k = $v['name_en'];
                    $data_array_y[$k] = $data_month["{$k}_todo"];
                }
            }
            $data_array_y['data'] = $data_month['data_todo'];


            $this->chartCreater4($todo_type['name_file'], $graph_name, $data_array_y, $data_month['data_time'], 'Количество заявок', 'Дата', 'Y-m-d', $max_y_scale, $text_angle, Yii::$app->params['colors_todo'][$param_array[0]]);
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
            $views_name = 'todo_month';
        }


        return $this->render($views_name, [
            'label' => $label,
            'label_disconnection' => $label_disconnection,
            'chart_name_month' => $chart_name_month,
            'data' => $data_month['data'],
            'year' => $param_array[1],
            'todo_type' => $param_array[0],
            'month' => $param_array[2],
            'name' => $todo_type['name'],
            'name_file' => $todo_type['name_file'],
            'menu_items_month' => $this->getMenuItemsMonth($param_array[0], $param_array[1], $param_array[2], $line),
            'line' => isset($line) ? 1 : null
        ]);


    }


    public function actionSelectData($year_start_table = null, $year_end_table = null, $todo_type_table = null, $todo_status_table = null, $todo_location_table = null)
    {


        $todoModel = new Todo();
        $modelTodoForm = new TodoForm();


        $u = explode('?', Yii::$app->request->url);

        $url_array = explode("/", $u[0]);

        $label = $todoModel->attributeLabels();
        $label_disconnection = $todoModel->attributeLabelsDisconnection();
        $date_today = Yii::$app->formatter->asDate('now', 'yyyy');

        $todo_type = 2;
        $todo_type_array = Yii::$app->params['todo_type'][$todo_type];
        $start_year = ($date_today - 1999) - Yii::$app->params['year-period-select-data'];
        $end_year = ($date_today - 1999);
        $start_period = $start_year . '01';
        $end_period = ($end_year) . '01';

        //   $start_period = 1201;
        //   $end_period = 1301;


        $todo_status = 0;//все
        $todo_location = 0; //все
//Debugger::Eho($start_year);

        if (Yii::$app->request->post()) {
            if (Yii::$app->request->post('TodoForm')['year_from'] <= Yii::$app->request->post('TodoForm')['year_to']) {
                $todo_t = Yii::$app->request->post('TodoForm')['todo_type'];
                $todo_type_array = Yii::$app->params['todo_type'][$todo_t];
                $start_p = Yii::$app->request->post('TodoForm')['year_from'];
                $end_p = (Yii::$app->request->post('TodoForm')['year_to'] + 1);
                $todo_st = $todo_t != 6 ? Yii::$app->request->post('TodoForm')['todo_status'] : 0; //исключаем статусы Тодо для отключений
                $todo_loc = Yii::$app->request->post('TodoForm')['todo_location'];


                $modelTodoForm->year_to = ($end_p - 1);
                $modelTodoForm->year_from = $start_p;
                $modelTodoForm->todo_type = $todo_t;
                $modelTodoForm->todo_status = $todo_st;
                $modelTodoForm->todo_location = $todo_loc;

            } else {
                Yii::$app->session->addFlash('dateHight', 'Дата начала приода должна быть меньше даты окончания периода! Введите данные еще раз.');

            }

        }


        if (isset($start_p) && isset($end_p) && isset($todo_t) && isset($todo_st) && isset($todo_loc)) {

            $todo_type = $todo_t;
            $start_year = $start_p;
            $end_year = $end_p;

            $start_period = $start_year . '01';
            $end_period = $end_year . '01';
            $todo_status = $todo_st;
            $todo_location = $todo_loc;


            // Debugger::testDie();
        }

        if (isset($year_start_table) && isset($year_end_table) && isset($todo_type_table)) {

            $todo_type = $todo_type_table;
            $start_year = round($year_start_table / 100);
//Debugger::Eho($start_year);
            //    Debugger::testDie();
            $end_year = round($year_end_table / 100);

            $start_period = $year_start_table;
            $end_period = $year_end_table;
            $todo_status = $todo_status_table;
            $todo_location = $todo_location_table;
            $todo_type_array = Yii::$app->params['todo_type'][$todo_type];
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

        $data = $this->todoData($todoModel, "Ym", $start_period, $end_period, $todo_type_array, 1, $todo_status, $todo_location);
//Debugger::PrintR($data);
        //      Debugger::testDie();
        $chart_name_year = 'charges_by_network_all';

        $todo_status_name = isset(Yii::$app->params['todo_status'][$todo_status]['name']) ? Yii::$app->params['todo_status'][$todo_status]['name'] : 'Все';

        $todo_location_a = Yii::$app->params['net_list'];
        $todo_location_name = $todo_location_a[$todo_location];
        //Debugger::Eho(($start_year + 2000));

        $graph_name = $todo_type_array['name'] . '. Период с  ' . ((int)$start_year + 2000) . '-01 по, ' . ((int)$end_year + 1999) . '-12. Статус TODO - "'.$todo_status_name.'". Сеть - "'.$todo_location_name.'".';

        $max_y_scale = max($data['data_todo']) < 200 ? 200 : (max($data['data_todo']) + 25);

        $text_angle = count($data['data_time']) < 15 ? 0 : 90;

        if (($end_period - $start_period) > 100) {
            array_pop($data['data_todo']); //удаление последнего пустого значения
            array_pop($data['data_time']);//удаление последнего пустого значения
        }


        $this->chartCreater1($todo_type_array['name_file'], $graph_name, $data['data_todo'], $data['data_time'], 'Количество TODO', 'Дата', 'Y-m', $max_y_scale, $text_angle, Yii::$app->params['colors_todo'][$todo_type]);

        if (isset($url_array[3])) {
            $line = null;
            if ($url_array[3] == 'table' && $todo_type != 6) {
                $views_name = 'todo_data_table';
            } elseif ($url_array[3] == 'table' && $todo_type == 6) {
                $views_name = 'todo_data_disconnections_table';
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
        $todo_type_a = array();
        for ($i = 1; $i <= 6; $i++) {
            $todo_type_a[$i] = $this->todoType($i)['name'];
        }
        $todo_status_a[] = 'Все';
        foreach (Yii::$app->params['todo_status'] as $k => $v) {
            $todo_status_a[] = $v['name'];
        }



        return $this->render($views_name, [
            'label' => $label,
            'label_disconnection' => $label_disconnection,
            'chart_name_year' => $chart_name_year,
            'data' => $data['data'],
            //  'year' => $param_array[1],
            'todo_type' => $todo_type,
            'name' => $todo_type_array['name'],
            'name_file' => $todo_type_array['name_file'],
            'menu_items_years' => $this->getMenuItemsYears($todo_type),
            'start_period' => $start_period,
            'end_period' => $end_period,
            'start_year' => $start_year,
            'end_year' => $end_year,
            'model_todo_form' => $modelTodoForm,
            'years_array' => $years_array,
            'todo_type_a' => $todo_type_a,
            'todo_status_a' => $todo_status_a,
            'todo_location_a' => $todo_location_a,
            'todo_location' => $todo_location,
            'todo_location_name' => $todo_location_name,
            'todo_status' => $todo_status,
            'todo_status_name' => $todo_status_name,
        ]);
    }


    private function todoData(Todo $todoModel, $format, $start_period, $end_period, $todo_type, $total_dif_todostatus = null, $todo_status = null, $todo_location = null)
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

        $todo_type['type_id'] == 100 ? $total_dif_todostatus = 0 : (isset($total_dif_todostatus) ? $total_dif_todostatus : 0);


        $data = $todoModel->TodoSelect($start_period, $end_period, $todo_type['type_id'], $todo_location);
        $todo_status_data = Yii::$app->params['todo_status'];


        //  Debugger::PrintR($todo_status_data);


        if ($todo_status) {
            foreach ($data as $k => $v) {
                if (!isset($todo_status_data[$todo_status]['data'][$v['todo_state']])) {
                    unset($data[$k]);
                }
            }
        }
        // Debugger::PrintR($data);
        //Debugger::testDie();
        $total_data = array();

        /*
         * Если есть параметр $total_dif_todostatus то дальнейший скрипт разбивает полученные данные на разные массивы
         * каждый из которых соответствует тодо на той или иной стадии обработк. Подобная обработка нужна чтоб уменьшить
         * количество запросов в базу.
         */

        foreach ($data as $k => $v) {

            if (isset($data[$k]['init_time'])) {
                if (strlen($data[$k]['init_time']) > 6) {
                    $data[$k]['init_time'] = round(($data[$k]['init_time'] / 10000));
                }
            } elseif (isset($data[$k]['last'])) {
                if (strlen($data[$k]['last']) > 6) {
                    $data[$k]['last'] = round(($data[$k]['last'] / 10000));
                }
            }
        }

        if ($total_dif_todostatus) {
            $data_income = array();
            $data_inwork = array();
            $data_complete = array();
            $data_delete = array();
            $data_repeat = array();

            foreach ($data as $k => $v) {

                if (isset($todo_status_data[1]['data'][$v['todo_state']])) {
                    $data_income[] = $v;
                } elseif (isset($todo_status_data[2]['data'][$v['todo_state']])) {
                    $data_inwork[] = $v;
                } elseif (isset($todo_status_data[3]['data'][$v['todo_state']])) {
                    $data_complete[] = $v;
                } elseif (isset($todo_status_data[4]['data'][$v['todo_state']])) {
                    $data_delete[] = $v;
                } elseif (isset($todo_status_data[5]['data'][$v['todo_state']])) {
                    $data_repeat[] = $v;
                }

            }
            $data = array(
                'data' => $data,
                'data_income' => $data_income,
                'data_inwork' => $data_inwork,
                'data_complete' => $data_complete,
                'data_delete' => $data_delete,
                'data_repeat' => $data_repeat,

            );
        } else {
            $data = array('data' => $data);
        }
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
                $init_time = $todo_type['type_id'] == 100 ? $v['last'] : $v['init_time'];

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

            foreach ($data_tm as $key => $val) {
                $d = $this->dateParsing($val);
                $data_time[] = $d;
            }
            //    Debugger::PrintR($data_time);


            $total_data["{$key_data}_todo"] = $data_count;
            $total_data["{$key_data}_time"] = $data_time;
            $total_data["{$key_data}"] = $data_array_dif;


        }

        if ($todo_type['type_id'] != 100) { //исключает преобразование для отключений в которых не актуальны стадии обработки тодо (это не тодо)
            if ($format == 'Ymd') { // преобразование массивов(для каждой стадии тодо) чтоб они были с одинаковым количеством
                //элементов, в противном случае не корректно отображаются на графике
                $todo_status_data = Yii::$app->params['todo_status'];

                foreach ($total_data['data_time'] as $key => $val) {
                    foreach ($todo_status_data as $v) {
                        $key_st = $v['name_en'] . '_time';
                        if (!in_array($val, $total_data[$key_st])) {
                            $total_data[$v['name_en'] . '_todo_'][] = 0;
                        } else {
                            $key_time = array_search($val, $total_data[$key_st]);
                            $total_data[$v['name_en'] . '_todo_'][] = $total_data[$v['name_en'] . '_todo'][$key_time];
                        }
                    }
                }
                foreach ($todo_status_data as $v) {
                    if (isset($total_data[$v['name_en'] . '_todo_'])) {
                        $total_data[$v['name_en'] . '_todo'] = $total_data[$v['name_en'] . '_todo_'];
                        unset($total_data[$v['name_en'] . '_todo_']);
                    }
                }

            }
        }

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
        if ($format == 'Y') { //образка последнего значения (пустое). Для построения графика год указывается +1 относительно
            //текущего года, поэтому не содержит данных, его необходимо удалить.
            foreach ($total_data as $k => $v) {
                if (strpos($k, '_time') || strpos($k, '_todo')) {
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


            $total_data['data_todo_full'] = array();
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
                            $total_data['data_todo_full'][] = $total_data['data_todo'][$key_time_ymd];
                            $total_data['data_time_full'][] = $date_new;
                        } else {
                            $total_data['data_todo_full'][] = 0;
                            $total_data['data_time_full'][] = $date_new;
                        }

                    }
                }
            }
        }

        return $total_data;
    }

    public function getTodoDataDifStatus($tottal_dif = null)
    {

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


    public function actionTodoDataLine()
    {
        $url_a = explode("/", Yii::$app->request->url);
        $param_a = explode("-", $url_a[2]);
        $n = count($param_a);

        if ($n == 3) {
            return $this->actionTodoQuantityMonth();
        } elseif ($n == 2 && $url_a[2] != 'select-data') {

            return $this->actionTodoQuantityYear();
        } elseif ($n == 2 && $url_a[2] == 'select-data') {
            return $this->actionSelectData();

        } elseif ($n == 1) {
            return 2;
        } else {
            return null;
        }

    }

    public function actionTodoDataTable()
    {
        //  $this->noDataRedirect();

        $url_get_array = explode("?", Yii::$app->request->url);

        $url_a = explode("/", $url_get_array[0]);

        $param_a = explode("-", $url_a[2]);

        $n = count($param_a);


        if ($n == 3) {
            return $this->actionTodoQuantityMonth();
        } elseif ($n == 2 && $url_a[2] != 'select-data' && $url_a[2] != 'multi-years') {

            return $this->actionTodoQuantityYear();
        } elseif (isset($url_a[2]) && $url_a[2] == 'select-data' && $url_a[3] == 'table') {


            return $this->actionSelectData(Yii::$app->request->get('year_start'), Yii::$app->request->get('year_end'), Yii::$app->request->get('todo_type'), Yii::$app->request->get('todo_status'), Yii::$app->request->get('todo_location'));

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
}