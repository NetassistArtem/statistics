<?php


namespace app\controllers;

use yii\base\Exception;
use yii\BaseYii;
use yii\debug\DebugAsset;
use yii\web\Controller;
use yii\web\UrlManager;
use app\models\Charges;
use app\models\ChargesForm;
use app\models\MultiYearsForm;
use Yii;
use app;
use yii\web\Request;
use app\components\debugger\Debugger;


class StatisticsController extends Controller
{

    private function chartCreater1($file_name, $chart_name, $data_y, $data_x, $name_y, $name_x, $date_format, $max_YAxis, $text_angle_X, array $color_pallet, $x_interval = 1)
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

    private function chartCreater3($file_name, $chart_name, $data_y, $data_x, $name_y, $name_x, $date_format, $max_YAxis, $text_angle_X, array $color_pallet, $x_interval = 1)
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

    private function chartCreater4($file_name, $chart_name, array $data_y_array, $data_x, $name_y, $name_x, $date_format,
                                   $max_YAxis, array $data_name_array, array $data_color_array)
    {
        //Debugger::PrintR($data_y);
        //Debugger::PrintR($data_y2);
        //Debugger::PrintR($data_y3);
        //Debugger::PrintR($data_y4);
        //Debugger::PrintR($data_y5);
        //Debugger::PrintR($data_y6);
        //Debugger::testDie();
        include_once(__DIR__ . '/../vendor/pChart/pChart/pData.class');
        include_once(__DIR__ . '/../vendor/pChart/pChart/pChart.class');

        // Dataset definition
        $DataSet = new \pData;

        $DataSet->SetXAxisFormat("date");
        $DataSet->AddPoint($data_x, "series_1");

        $series_array = array();

        foreach($data_y_array as $k => $v){
          //  $i ++;
            $DataSet->AddPoint($v, "series_$k");
            $series_array[] = "series_$k";
        }

                foreach($data_y_array as $k => $v){
                    $DataSet->AddSerie("series_$k");
                }


        $DataSet->SetAbsciseLabelSerie("series_1");
        foreach($data_y_array as $k => $v){

            $DataSet->SetSerieName($data_name_array[$k], "series_$k");

        }

        $DataSet->SetYAxisName($name_y);
        $DataSet->SetXAxisName($name_x);


        // Initialise the graph
        $Test = new \pChart(1170, 545);
$i = 0;
        foreach($data_color_array as $key => $val){
            $Test->setColorPalette($i, $val[0], $val[1], $val[2]);
            $i++;
        }

        $Test->setDateFormat($date_format);
        $Test->setFixedScale(0, $max_YAxis, 10);
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 8);
        $Test->setGraphArea(70, 30, 1120, 450);
        $Test->drawFilledRoundedRectangle(7, 7, 1163, 538, 5, 240, 240, 240);
        $Test->drawRoundedRectangle(5, 5, 1165, 540, 5, 230, 230, 230);
        $Test->drawGraphArea(255, 255, 255, TRUE);
        $Test->drawScale($DataSet->GetData(), $DataSet->GetDataDescription(), SCALE_NORMAL, 150, 150, 150, TRUE, 90, 0);
        $Test->drawGrid(4, TRUE, 230, 230, 230, 50);

        // Draw the 0 line
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 6);
        $Test->drawTreshold(0, 143, 55, 72, TRUE, TRUE);

        // Draw the line graph

        $Test->drawLineGraph($DataSet->GetData(), $DataSet->GetDataDescription());
        $Test->drawPlotGraph($DataSet->GetData(), $DataSet->GetDataDescription(), 3, 2, 255, 255, 255);

        // Write values
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 12);
        $Test->writeValues($DataSet->GetData(), $DataSet->GetDataDescription(), $series_array);

        // Finish the graph
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 8);
        $Test->drawLegend(75, 35, $DataSet->GetDataDescription(), 255, 255, 255);
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 10);
        $Test->drawTitle(550, 22, $chart_name, 50, 50, 50, 585);
        $Test->Render(__DIR__ . '/../web/images/' . $file_name . '.png');

    }

    private function chartCreater5($file_name, $chart_name, array $data_y, $data_x, $name_y, $name_x, $max_YAxis, $text_angle_X, $x_interval = 1)
    {
        include_once(__DIR__ . '/../vendor/pChart/pChart/pData.class');
        include_once(__DIR__ . '/../vendor/pChart/pChart/pChart.class');

        // Dataset definition
        $DataSet = new \pData;

        //  $DataSet->SetXAxisFormat("date");
        $DataSet->AddPoint($data_x, "series_1x");

        $series_a = array();
        foreach ($data_y as $k => $v) {
            $DataSet->AddPoint($v, "series_$k");
            $DataSet->SetSerieName($k, "series_$k");
            $series_a[] = "series_$k";
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
        $Test->setFixedScale(0, $max_YAxis, 10);
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
        if (count($series_a) <= 2) {
            $Test->writeValues($DataSet->GetData(), $DataSet->GetDataDescription(), $series_a);
        }
        // Finish the graph
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 8);
        $Test->drawLegend(75, 35, $DataSet->GetDataDescription(), 255, 255, 255);
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 10);
        $Test->drawTitle(550, 22, $chart_name, 50, 50, 50, 585);
        $Test->Render(__DIR__ . '/../web/images/' . $file_name . '.png');

    }


    // преобразует не стандартный формат даты полученный из базы данных в формат неоьходимый для построения графиков
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

    /**
     * @param $number
     *
     * функция принимает условное обозначение комбинации выборки пользователей.
     * Возвращает для данной комбинации пользователей $user_class и $net_id и $net_id_operator
     * $number может иметь следующие значения
     * 1  соответствует $net_id = 101  $user_class = 0  $net_id_operator = "<"  Домашние абоненты
     * 2  соответствует $net_id = 199  $user_class = 1  $net_id_operator = "<="  Бизнес абоненты с домосетью
     * 3  соответствует $net_id = 200  $user_class = 1  $net_id_operator = "="  Бизнес абоненты магистральные
     * 4  соответствует $net_id = 199  $user_class = ''  $net_id_operator = "<="  Домосеть
     * 5  соответствует $net_id = 200  $user_class = ''  $net_id_operator = "<="  Все
     */
    private function usersType($number)
    {
        switch ($number) {
            case 1 :
                return Yii::$app->params['users_type'][1];
                break;
            case 2 :
                return Yii::$app->params['users_type'][2];
                break;
            case 3 :
                return Yii::$app->params['users_type'][3];
                break;
            case 4 :
                return Yii::$app->params['users_type'][4];
                break;
            case 5 :
                return Yii::$app->params['users_type'][5];
                break;
            case 6 :
                return Yii::$app->params['users_type'][6];
                break;
            case 7 :
                return Yii::$app->params['users_type'][7];
                break;
            default:
                return Yii::$app->params['users_type'][1];
                break;

        }

    }

    private function getMenuItemsYears($users_type, $year = 0, $line = 0)
    {
        $menu_years_item = array();
        for ($i = 2007; $i <= Yii::$app->formatter->asDate(time(), 'Y'); $i++) {
            $menu_years_item[] = ['label' => "$i", 'url' => "/charges/$users_type-$i", "options" => ["id" => "$i"], 'active' => ("/charges/$users_type-$i" == Yii::$app->request->url || "/charges/$users_type-$i/line" == Yii::$app->request->url) ||
                strpos(Yii::$app->request->url, (string)$i)];

        }
        // $menu_years_item[] = ['label' => "Таблица данных", 'url' => Yii::$app->request->url.'/table','options' => ['class' => 'navbar_right_menu']];

        if (!$line && !is_array($year)) {
            $y = '/charges/' . $users_type . '-' . $year . '/line';
            $name = 'Линейный график';
        } elseif (!is_array($year)) {
            $y = '/charges/' . $users_type . '-' . $year;
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
            $menu_years_item[] = '<li class="batton_position_3"> <p><a class="btn btn-default btn-lg" href="' . $y . '">' . $name . '</a></p></li>';

        }

        //"<li class='batton_position_1'><p ><a class='btn btn-default btn-lg' href='$url_total'> График общий </a></p></li>"
        return $menu_years_item;
    }

    private function getMenuItemsMonth($users_type, $year, $month, $line = 0)
    {
        $menu_month_item = array();
        for ($i = 1; $i <= 12; $i++) {

            $i_text = $i < 10 ? '0' . $i : $i;
            $menu_month_item[] = ['label' => "$i_text", 'url' => "/charges/$users_type-$year-$i_text", 'active' => ("/charges/$users_type-$year-$i_text" == Yii::$app->request->url || "/charges/$users_type-$year-$i_text/line" == Yii::$app->request->url)];
        }

        if (!$line) {
            $y = '/charges/' . $users_type . '-' . $year . '-' . $month . '/line';
            $name = 'Линейный график';
        } else {
            $y = '/charges/' . $users_type . '-' . $year . '-' . $month;
            $name = 'Столбцовый график';
        }

        $menu_month_item[] = '<li class="batton_position_4"> <p><a class="btn btn-default btn-lg" href="' . $y . '">' . $name . '</a></p></li>';

        return $menu_month_item;
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
            $date_before = Yii::$app->params['date-before'];
            $date_before_array = explode("-", $date_before);
            $date_before = $date_before_array[0] . '-' . $date_before_array[1];
            $date_before_timestamp = Yii::$app->formatter->asTimestamp($date_before);
        } elseif (isset($param_array[1])) {
            $date_request = $param_array[1] . '-01';
            $date_request_timestamp = Yii::$app->formatter->asTimestamp($date_request);
            //$date_now_timestamp = Yii::$app->formatter->asTimestamp('now');
            $date_now = Yii::$app->formatter->asDate('now', 'yyyy') . '-01';
            $date_now_timestamp = Yii::$app->formatter->asTimestamp($date_now);
            $date_before = Yii::$app->params['date-before'];
            $date_before_array = explode("-", $date_before);
            $date_before = $date_before_array[0] . '-01';
            $date_before_timestamp = Yii::$app->formatter->asTimestamp($date_before);
        } else {
            return null;
        }
        if (($date_request_timestamp < $date_before_timestamp) || ($date_request_timestamp > $date_now_timestamp)) {


            // $this->redirect('/charges/no-data');
            //exit();
            header('Location: /charges/no-data');
            exit;
        }


    }

    /**
     *
     * @param $format - формат даты год - "Y", месяц - "Ym", день - "Ymd"
     * @param $start_period - начальная дата периода выборки. Необходимо чтоб формат $format соответствовал
     * вводимой дате $start_period,
     * например если $format = "Y" то $start_period = 5 (означает 2005 год) (или 12 означает 2012 т.д.)
     * например $format = "Ym" то $start_period = 502 (означает 2005 02),
     * например $format = "Ymd" то $start_period = 50223 (означает 2005 02 23),
     */
    private function totalCharges(Charges $chargesModel, $format, $start_period, $end_period, $net_id_operator, $net_id, $user_class, $user_class_unuse = 0, $additional_condition = '')
    {

        if ($format == 'Y') {
            $date_today = Yii::$app->formatter->asDate(time(), 'Y');
            $date_end_array = str_split($date_today, 2);
            $end_period = $end_period ? $end_period : $date_end_array[1] . +1;
            $scale = "100/100/100/10000";
        } elseif ($format == 'Ym') {
            $date_today = Yii::$app->formatter->asDate('now', 'yyyyMM');
            $date_end_array = str_split($date_today, 2);
            $end_period = $end_period ? $end_period : ($date_end_array[1] . +1) . $date_end_array[2];
            $scale = "100/100/10000";

        } elseif ($format == 'Ymd') {
            $date_today = Yii::$app->formatter->asDate(time(), 'Ymd');
            $date_end_array = str_split($date_today, 2);
            $end_period = $end_period ? $end_period : ($date_end_array[1] . +1) . $date_end_array[2] . $date_end_array[2];
            $scale = "100/10000";
        } else {
            throw new \PDOException('Введен не правильный формат даты');
        }

        //    $data_test = $chargesModel->ChargesByNetworkTest($scale, $start_period, $end_period, $net_id_operator, $net_id, $user_class, $user_class_unuse,200, "=");
        //    Debugger::PrintR($data_test);
        //    Debugger::testDie();


//Debugger::Eho($start_period);
  //      Debugger::Eho('</br>');
      //  $additional_condition =
        $data = $chargesModel->ChargesByNetwork($scale, $start_period, $end_period, $net_id_operator, $net_id, $user_class, $user_class_unuse, $additional_condition);

//Debugger::PrintR($data);

        $e_p = $end_period < 100 ? $end_period : round($end_period / 100);
        $s_p = $start_period < 100 ? $start_period : round($end_period / 100);


        if ($format == 'Ym' && $e_p - $s_p <= 1) {

            $data_2 = array();

            foreach ($data as $k_1 => $v_1) {
                $data_2[$v_1['ts']] = $v_1;
            }

            $data_3 = array();



            if(strlen($start_period)<= 2){
                $i = $start_period . '01';
                $i_end = $start_period . '01';
                $i = (int)$i;
                $i_end = (int)$i_end;
            }else{
                $i = (int)$start_period;
                $i_end = (int)$start_period;
            }


            while ($i < ((int)$i_end + 12)) {

                if (isset($data_2[$i])) {
                    $data_3[$i] = $data_2[$i];
                } else {
                    $data_3[$i]['ts'] = $i;
                    $data_3[$i]['pay'] = 0;
                }

                $i++;
            }


            $data = array();

            foreach ($data_3 as $v) {
                $data[] = $v;
            }
        }


        $data_time = array();
        $data_charge = array();


        foreach ($data as $key => $val) {
            $d = $this->dateParsing($val['ts']);

            // print_r($data[$val]);
            //  $data[$key]['ts'] = $d;
            $data_charge[] = round($val['pay'] / 1000);
            $data_time[] = $d; //$val['ts'];
            // print_r($data_time);

        }

        $total_data = array(
            'data_charge' => $data_charge,
            'data_time' => $data_time,
            'data' => $data
        );




        return $total_data;
    }

    private function multiYearsDataParsing($data, $start_period, $end_period)
    {
        $data_2 = array();

        foreach ($data as $k_1 => $v_1) {
            $data_2[$v_1['ts']] = $v_1;
        }
        $data_3 = array();

        $i = $start_period * 100 + 1;
        while ($i <= ($end_period - 1) * 100 + 12) {

            if (isset($data_2[$i])) {
                $data_3[$i] = $data_2[$i];
            } else {
                $data_3[$i]['ts'] = $i;
                $data_3[$i]['pay'] = 0;
            }

            $n = (int)substr($i, -2, 2);
            if ($n < 12) {
                $i++;

            } else {
                $i = $i - $n + 101;

            }
        }
        $data_4 = array_chunk($data_3, 12);
        $data_5 = array();

        for ($i = $start_period; $i <= $end_period; $i++) {
            if (isset($data_4[$i - $start_period])) {
                $data_5[$i + 2000] = $data_4[$i - $start_period];
            }
        }
        $data_6 = array();
        foreach ($data_5 as $k => $v) {
            foreach ($v as $key => $value) {
                $data_6[$k][] = round($value['pay'] / 1000);
            }

        }


        // echo $i.'</br>';
        //  print_r($data_6);
        /**
         * $start_p_full = $start_period + 2000;
         * $end_p_full = $end_period + 1999;
         * $year_start = array();
         * $year_end = array();
         * foreach ($data as $k => $v) {
         * if ($v['ts'] <= $start_period * 100 + 12) {
         * $year_start[$start_p_full][] = $v;
         * unset($data[$k]);
         * }
         * if ($v['ts'] >= ($end_period - 1) * 100) {
         * $year_end[($end_p_full)][] = $v;
         * unset($data[$k]);
         * }
         * }
         *
         * $n_sp = 12 - count($year_start[$start_p_full]);
         * $n_ep = count($year_end[$end_p_full]);
         * $year_start_full = array();
         * for ($i = 1; $i <= $n_sp; $i++) {
         * $i_val = $start_period * 100 + $i;
         * $year_start_full[$start_p_full][] = array('ts' => "$i_val", 'pay' => '');
         * }
         * foreach ($year_start[$start_p_full] as $v) {
         * $year_start_full[$start_p_full][] = array('ts' => $v['ts'], 'pay' => $v['pay']);
         * }
         *
         * for ($i = ($n_ep + 1); $i <= 12; $i++) {
         * $i_v = ($end_period - 1) * 100 + $i;
         * $year_end[$end_p_full][] = array('ts' => "$i_v", 'pay' => '');
         * }
         *
         * $test_array_years = $year_start_full;
         * $test_array = array_chunk($data, 12);
         * foreach ($test_array as $k => $v) {
         * $test_array_years[($start_p_full + 1) + $k] = $v;
         * }
         * $test_array_years[] = $year_end[$end_p_full];
         * $data_array_simple = array();
         *
         * foreach ($test_array_years as $k => $v) {
         * foreach ($v as $key => $value) {
         * $data_array_simple[$k][] = round($value['pay'] / 1000);
         * }
         *
         * }
         **/
        $data = array(
            'full' => $data_5,
            'simple' => $data_6
        );

        //  print_r($data['simple']);

        return $data;
    }

    private function fileWrite($data,$file_name)
    {
        $serialize_data = serialize($data);
        file_put_contents($file_name, $serialize_data);
    }
    private function getFileContent($file_name)
    {
        if(file_exists($file_name)){
            $data = file_get_contents($file_name);
            return unserialize($data);
        }else {
            return false;
        }
    }
    private function timeFileRewrite($data)//возвращает True если надо записывать файл и false если не надо, true также если данных нет
    {
        if($data){
            end($data['home']['data']);
            $last_key =  key($data['home']['data']);
            $last_year = $data['home']['data'][$last_key]['ts'];
            $year_today = Yii::$app->formatter->asDate('now', 'yy');
            $dif = $year_today - $last_year;
            if($dif > 1){
                return true;
            }else{
                return false;
            }
          //  Debugger::Eho($last_year);
         //   Debugger::Eho('</br>');
          //  Debugger::Eho($year_today);
        }else{
           return true;
        }


       // Debugger::Eho($last_key);
       // Debugger::testDie();

    }


    public function actionChargesByNetwork()
    {
        $chargesModel = new Charges();


        $file_data = $this->getFileContent('charges_total.php');

        $time_start_rewrite = $this->timeFileRewrite($file_data);
       // Debugger::VarDamp($time_start_rewrite);
       // Debugger::PrintR($file_data);
        $date_today = Yii::$app->formatter->asDate('now', 'yy');
        if(!$file_data || $time_start_rewrite){

            $data_file_write = array();

            $date_to = $date_today;
      //  Debugger::Eho($date_to);
       // Debugger::testDie();
            for ($i = 1; $i <= 7; $i++){
                $user_type_data = $this->usersType($i);

                $data_file_write[$user_type_data['name_teh']] = $this->totalCharges($chargesModel, "Y", "5", $date_to, $user_type_data['net_id_operator'], $user_type_data['net_id'], $user_type_data['user_class'], $user_type_data['user_class_unuse'], $user_type_data['additional_condition']);

            }
            /**
            $data2_home = $this->totalCharges($chargesModel, "Y", "5", $date_to, "<", 101, 0);
            $data2_business_homenetwork = $this->totalCharges($chargesModel, "Y", "5", $date_to, "<=", 199, 1);
            $data2_business_trunk = $this->totalCharges($chargesModel, "Y", "5", $date_to, "=", 200, 1);
            $data2_homenetwork = $this->totalCharges($chargesModel, "Y", "5", $date_to, "<=", 199, '', 1);
            $data2_providers = $this->totalCharges($chargesModel, "Y", "5", $date_to, "=", 301, '', 1);
            $data2_all = $this->totalCharges($chargesModel, "Y", "5", $date_to, "<=", 200, '', 1);
            $data_file_write = array(
                'home' => $data2_home,
                'business_homenetwork' => $data2_business_homenetwork,
                'homenetwork' => $data2_homenetwork,
                'business_trunk' => $data2_business_trunk,
                'providers' => $data2_providers,
                'all' => $data2_all,
            );
             * **/
      //      Debugger::testDie();

            $data_f_w2 = array();
            foreach($data_file_write as $k => $v){
                if(count($v['data_charge']) < count($data_file_write['all']['data_charge'])){
                    foreach($data_file_write['all']['data_time'] as $key => $val ){
                        $n = array_search( $val, $v['data_time']);

                        if($n !== false){
                            $data_f_w2[$k]['data_charge'][$key] = $v['data_charge'][$n];
                            $data_f_w2[$k]['data'][$key] = $v['data'][$n];
                        }else{
                            $data_f_w2[$k]['data_charge'][$key] = 0;
                            $data_f_w2[$k]['data'][$key]['ts'] = $data_file_write['all']['data'][$key]['ts'];
                            $data_f_w2[$k]['data'][$key]['pay'] = 0;


                        }

                    }
                    $data_f_w2[$k]['data_time'] = $data_file_write['all']['data_time'];


                }else{
                    $data_f_w2[$k] = $v;
                }
            }
           // Debugger::PrintR($data_f_w2);




            $this->fileWrite($data_f_w2,'charges_total.php');
            $file_data = $this->getFileContent('charges_total.php');
        }



        //Debugger::PrintR($this->getFileContent('charges_total.php'));
        //Debugger::testDie();
       // Debugger::PrintR($file_data);
       // Debugger::testDie();
        $label = $chargesModel->attributeLabels();
        $data_total = array();

        for ($i = 1; $i <= 7; $i++){
            $user_type_data = $this->usersType($i);
            $teh_name = $user_type_data['name_teh'];

            $data_{$teh_name} = $this->totalCharges($chargesModel, "Y", $date_today, 0, $user_type_data['net_id_operator'], $user_type_data['net_id'], $user_type_data['user_class'],  $user_type_data['user_class_unuse'], $user_type_data['additional_condition']);
         //   Debugger::PrintR($data_{$teh_name});
            $data_{$teh_name.'_all'} = array(
                'data_charge' => array_merge($file_data[$teh_name]['data_charge'],$data_{$teh_name}['data_charge']),
                'data_time' => array_merge($file_data[$teh_name]['data_time'],$data_{$teh_name}['data_time']),
                'data' => array_merge($file_data[$teh_name]['data'],$data_{$teh_name}['data']),
            );
            //$data_te =$this->getFileContent('test.php');
            // Debugger::PrintR($data_te);

            $chart_name_{$teh_name} = 'charges_by_network_'.$teh_name;
            $color_pallet_{$teh_name} = Yii::$app->params['colors_statistic'][$i];
            $max_y_scale_{$teh_name} = max($data_{$teh_name.'_all'}['data_charge'])+500;
            $this->chartCreater1($chart_name_{$teh_name}, $user_type_data['name'], $data_{$teh_name.'_all'}['data_charge'], $data_{$teh_name.'_all'}['data_time'], 'Выручка, тысяч грн', 'Дата', 'Y', $max_y_scale_{$teh_name}, 90, $color_pallet_{$teh_name});
            $data_total[$teh_name]['data'] = $data_{$teh_name.'_all'}['data'];
            $data_total[$teh_name]['chart_name'] = $chart_name_{$teh_name};
            $data_total[$teh_name]['data_charge'] = $data_{$teh_name.'_all'}['data_charge'];
            $data_total[$teh_name]['data_time'] = $data_{$teh_name.'_all'}['data_time'];
            $data_total[$teh_name]['max_y_scale'] = $max_y_scale_{$teh_name};
            $data_total[$teh_name]['name'] = $user_type_data['name'];
            $data_total[$teh_name]['color_pallet'] = $color_pallet_{$teh_name};
            $data_total[$teh_name]['n'] = $i;
        }
       // Debugger::PrintR($data_total);
       // Debugger::testDie();
/**

        $data_home = $this->totalCharges($chargesModel, "Y", $date_today, 0, "<", 101, 0);
        $data_home_all = array(
            'data_charge' => array_merge($file_data['home']['data_charge'],$data_home['data_charge']),
            'data_time' => array_merge($file_data['home']['data_time'],$data_home['data_time']),
            'data' => array_merge($file_data['home']['data'],$data_home['data']),
        );
        //$data_te =$this->getFileContent('test.php');
       // Debugger::PrintR($data_te);
        $label = $chargesModel->attributeLabels();
        $chart_name_home = 'charges_by_network_home';
        $color_pallet_home = array(100, 149, 237);
        $max_y_scale_home = max($data_home['data_charge'])+500;
        $this->chartCreater1('charges_by_network_home', "Домашние абоненты", $data_home_all['data_charge'], $data_home_all['data_time'], 'Выручка, тысяч грн', 'Дата', 'Y', $max_y_scale_home, 90, $color_pallet_home);

        $data_business_homenetwork = $this->totalCharges($chargesModel, "Y", $date_today, 0, "<=", 199, 1);
        $data_business_homenetwork_all = array(
            'data_charge' => array_merge($file_data['business_homenetwork']['data_charge'],$data_business_homenetwork['data_charge']),
            'data_time' => array_merge($file_data['business_homenetwork']['data_time'],$data_business_homenetwork['data_time']),
            'data' => array_merge($file_data['business_homenetwork']['data'],$data_business_homenetwork['data']),
        );
       // Debugger::PrintR($data_business_homenetwork_all);
        $chart_name_business_homenetwork = 'charges_by_network_business_homenetwork';
        $color_pallet_business_homenetwork = array(60, 179, 113);
        $max_y_scale_business_homenetwork = max($data_business_homenetwork['data_charge'])+500;
        $this->chartCreater1('charges_by_network_business_homenetwork', "Бизнес абоненты с домосетью", $data_business_homenetwork_all['data_charge'], $data_business_homenetwork_all['data_time'], 'Выручка, тысяч грн', 'Дата', 'Y', $max_y_scale_business_homenetwork, 90, $color_pallet_business_homenetwork);

        $data_business_trunk = $this->totalCharges($chargesModel, "Y", $date_today, 0, "=", 200, 1);
        $data_business_trunk_all = array(
            'data_charge' => array_merge($file_data['business_trunk']['data_charge'],$data_business_trunk['data_charge']),
            'data_time' => array_merge($file_data['business_trunk']['data_time'],$data_business_trunk['data_time']),
            'data' => array_merge($file_data['business_trunk']['data'],$data_business_trunk['data']),
        );
        $chart_name_business_trunk = 'charges_by_network_business_trunk';
        $color_pallet_business_trunk = array(255, 215, 0);
        $max_y_scale_business_trunk = max($data_business_trunk['data_charge'])+500;
        $this->chartCreater1('charges_by_network_business_trunk', "Бизнес абоненты магистральные", $data_business_trunk_all['data_charge'], $data_business_trunk_all['data_time'], 'Выручка, тысяч грн', 'Дата', 'Y', $max_y_scale_business_trunk, 90, $color_pallet_business_trunk);

        $data_homenetwork = $this->totalCharges($chargesModel, "Y", $date_today, 0, "<=", 199, '', 1);
        $data_homenetwork_all = array(
            'data_charge' => array_merge($file_data['homenetwork']['data_charge'],$data_homenetwork['data_charge']),
            'data_time' => array_merge($file_data['homenetwork']['data_time'],$data_homenetwork['data_time']),
            'data' => array_merge($file_data['homenetwork']['data'],$data_homenetwork['data']),
        );
        $chart_name_homenetwork = 'charges_by_network_homenetwork';
        $color_pallet_homenetwork = array(178, 34, 34);
        $max_y_scale_homenetwork = max($data_homenetwork['data_charge'])+500;
        $this->chartCreater1('charges_by_network_homenetwork', "Домосеть", $data_homenetwork_all['data_charge'], $data_homenetwork_all['data_time'], 'Выручка, тысяч грн', 'Дата', 'Y', $max_y_scale_homenetwork, 90, $color_pallet_homenetwork);

        $data_providers = $this->totalCharges($chargesModel, "Y", $date_today, 0, "=", 301, '', 1);
        $data_providers_all = array(
            'data_charge' => array_merge($file_data['providers']['data_charge'],$data_providers['data_charge']),
            'data_time' => array_merge($file_data['providers']['data_time'],$data_providers['data_time']),
            'data' => array_merge($file_data['providers']['data'],$data_providers['data']),
        );
        $chart_name_providers = 'charges_by_providers';
        $color_pallet_providers = array(255, 000, 255);
        $max_y_scale_providers = max($data_providers['data_charge'])+500;
        $this->chartCreater1('charges_by_network_providers', "Провайдеры", $data_providers_all['data_charge'], $data_providers_all['data_time'], 'Выручка, тысяч грн', 'Дата', 'Y', $max_y_scale_providers, 90, $color_pallet_providers);


        $data_all = $this->totalCharges($chargesModel, "Y", $date_today, 0, "<=", 200, '', 1);
        $data_all_all = array(
            'data_charge' => array_merge($file_data['all']['data_charge'],$data_all['data_charge']),
            'data_time' => array_merge($file_data['all']['data_time'],$data_all['data_time']),
            'data' => array_merge($file_data['all']['data'],$data_all['data']),
        );
        $chart_name_all = 'charges_by_network_all';
        $color_pallet_all = array(105, 105, 105);
        $max_y_scale_all = max($data_all['data_charge'])+500;
        $this->chartCreater1('charges_by_network_all', "Все абоненты", $data_all_all['data_charge'], $data_all_all['data_time'], 'Выручка, тысяч грн', 'Дата', 'Y', $max_y_scale_all, 90, $color_pallet_all);

**/
       // Debugger::PrintR($data_total);
        $data_y_array = array();
        $data_name_array = array();
        $data_color_array = array();
        foreach($data_total as $k => $v){
            $data_y_array[$k] = $v['data_charge'];
            $data_name_array[$k] = $v['name'];
            $data_color_array[$k] = $v['color_pallet'];
        }
        $chart_name_allinone = 'charges_by_network_allinone';
        $this->chartCreater4('charges_by_network_allinone', "Все абоненты", $data_y_array, $data_total['all']['data_time'],
            'Выручка, тысяч грн', 'Дата', 'Y', $data_total['all']['max_y_scale'], $data_name_array, $data_color_array);



        return $this->render('charges_by_network', [

            'label' => $label,
            'chart_name_home' =>  $data_total['home']['chart_name'],
            'year_now' => Yii::$app->formatter->asDate('now', 'Y'),
            'chart_name_allinone' => $chart_name_allinone,
            'data' => $data_total,
        ]);

    }

    // public function actionChargesByNetwork()

    public function actionChargesYear()
    {
        $this->noDataRedirect();

        $url_array = explode("/", Yii::$app->request->url);
        $param_array = explode("-", $url_array[2]);
        // print_r($param_array);
        $year_start_array = str_split($param_array[1], 2);
        $start_period = $year_start_array[1] . '01';

        $end_period = $year_start_array[1] < 9 ? '0' . ($year_start_array[1] + 1) . '01' : $year_start_array[1] + 1 . '01';

        $users_type = $this->usersType($param_array[0]);

        $user_class_unuse = $users_type['user_class_unuse'];//  $param_array[0] > 3 ? 1 : 0;

        //print_r($year_start);


        $chargesModel = new Charges();

        $label = $chargesModel->attributeLabels();

        $graph_name = $users_type['name'] . ', ' . $param_array[1] . ' год';
        $chart_name_year = 'charges_by_network_all';

        if (isset($url_array[3]) && $url_array[3] == 'line') {
            $data_year = $this->totalCharges($chargesModel, "Ymd", $start_period, $end_period, $users_type['net_id_operator'], $users_type['net_id'], $users_type['user_class'], $user_class_unuse, $users_type['additional_condition']);

            $max_y_scale = max($data_year['data_charge']) < 60 ? 60 : (max($data_year['data_charge']) + 5);

            $this->chartCreater2($users_type['name_file'], $graph_name, $data_year['data_charge'], $data_year['data_time'], 'Выручка, тысяч грн', 'Дата', 'Y-m-d', $max_y_scale, 90, Yii::$app->params['colors_statistic'][$param_array[0]], 7);

        } else {
            $data_year = $this->totalCharges($chargesModel, "Ym", $start_period, $end_period, $users_type['net_id_operator'], $users_type['net_id'], $users_type['user_class'], $user_class_unuse, $users_type['additional_condition']);

            $max_y_scale = (max($data_year['data_charge']) < 600 && max($data_year['data_charge']) > 200 )? 600 : (max($data_year['data_charge']) + 50);

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
                        $d_y['data_charge'][$i] = $data_year['data_charge'][$i];
                    } else {
                        $d_y['data_time'][$i] = $d;
                        $d_y['data_charge'][$i] = '';
                    }
                }
                $d_y['data'] = $data_year['data'];

                $data_year = $d_y;
                // print_r($data_year);
            }
            //print_r($data_year);


            $this->chartCreater3($users_type['name_file'], $graph_name, $data_year['data_charge'], $data_year['data_time'], 'Выручка, тысяч грн', 'Дата', 'Y-m', $max_y_scale, 0, Yii::$app->params['colors_statistic'][$param_array[0]]);
        }
        $line = 0;
        if (isset($url_array[3])) {
            if ($url_array[3] == 'table') {
                $views_name = 'get_data_table';
            } elseif ($url_array[3] == 'line') {
                $views_name = 'charges_year';
                $line = 1;
            } else {
                throw new Exception('Страница не найдена');
            }
        } else {
            $views_name = 'charges_year';
        }


        return $this->render($views_name, [
            'label' => $label,
            'chart_name_year' => $chart_name_year,
            'data' => $data_year['data'],
            'year' => $param_array[1],
            'user_type' => $param_array[0],
            'name' => $users_type['name'],
            'name_file' => $users_type['name_file'],
            'menu_items_years' => $this->getMenuItemsYears($param_array[0], $param_array[1], $line),
            'line' => $line
        ]);
    }

    public function actionChargesMonth()
    {

        // $this->redirect('/charges/no-data');

        $this->noDataRedirect();

        $url_array = explode("/", Yii::$app->request->url);

        $param_array = explode("-", $url_array[2]);
        // print_r($param_array);
        $year_start_array = str_split($param_array[1], 2);
        $start_period = $year_start_array[1] . $param_array[2];
        $end_period = $param_array[2] < 9 ? $year_start_array[1] . '0' . ($param_array[2] + 1) : $year_start_array[1] . ($param_array[2] + 1);

        $users_type = $this->usersType($param_array[0]);

        $user_class_unuse = $users_type['user_class_unuse'];// $param_array[0] > 3 ? 1 : 0;

        $chargesModel = new Charges();

        $label = $chargesModel->attributeLabels();

        $chart_name_year = 'charges_by_network_all';

        $graph_name = $users_type['name'] . ', ' . $param_array[1] . ' год, ' . $param_array[2] . ' месяц';

        if (isset($url_array[3]) && $url_array[3] == 'line') {
            $data_month = $this->totalCharges($chargesModel, "Ymd", $start_period, $end_period, $users_type['net_id_operator'], $users_type['net_id'], $users_type['user_class'], $user_class_unuse, $users_type['additional_condition']);

            $max_y_scale = max($data_month['data_charge']) < 50 ? 50 : (max($data_month['data_charge']) + 5);
            $text_angle = count($data_month['data']) < 15 ? 0 : 90;

            $this->chartCreater1($users_type['name_file'], $graph_name, $data_month['data_charge'], $data_month['data_time'], 'Выручка, тысяч грн', 'Дата', 'Y-m-d', $max_y_scale, $text_angle, Yii::$app->params['colors_statistic'][$param_array[0]], 1);

        } else {
            $data_month = $this->totalCharges($chargesModel, "Ymd", $start_period, $end_period, $users_type['net_id_operator'], $users_type['net_id'], $users_type['user_class'], $user_class_unuse, $users_type['additional_condition']);
            $max_y_scale = max($data_month['data_charge']) < 50 ? 50 : (max($data_month['data_charge']) + 5);

            $text_angle = count($data_month['data']) < 15 ? 0 : 90;
            $this->chartCreater3($users_type['name_file'], $graph_name, $data_month['data_charge'], $data_month['data_time'], 'Выручка, тысяч грн', 'Дата', 'Y-m-d', $max_y_scale, $text_angle, Yii::$app->params['colors_statistic'][$param_array[0]]);
        }
        $line = 0;
        if (isset($url_array[3])) {
            if ($url_array[3] == 'table') {
                $views_name = 'get_data_table';
            } elseif ($url_array[3] == 'line') {
                $views_name = 'charges_month';
                $line = 1;
            } else {
                throw new Exception('Страница не найдена');
            }
        } else {
            $views_name = 'charges_month';
        }


        return $this->render($views_name, [
            'label' => $label,
            'chart_name_year' => $chart_name_year,
            'data' => $data_month['data'],
            'year' => $param_array[1],
            'user_type' => $param_array[0],
            'month' => $param_array[2],
            'name' => $users_type['name'],
            'name_file' => $users_type['name_file'],
            'menu_items_month' => $this->getMenuItemsMonth($param_array[0], $param_array[1], $param_array[2], $line),
            'line' => isset($line) ? 1 : null
        ]);


    }


    public function actionGetDataTable()
    {
        $this->noDataRedirect();

        $url_a = explode("/", Yii::$app->request->url);
        $param_a = explode("-", $url_a[2]);

        $n = count($param_a);


        if ($n == 3) {
            return $this->actionChargesMonth();
        } elseif ($n == 2 && $url_a[2] != 'select-data' && $url_a[2] != 'multi-years') {

            return $this->actionChargesYear();
        } elseif (isset($url_a[2]) && $url_a[2] == 'select-data') {

            return $this->actionSelectData(Yii::$app->request->get('year_start'), Yii::$app->request->get('year_end'), Yii::$app->request->get('user_type'));

        } elseif ($n == 1 && $url_a[4] == 'table') {
            return $this->actionChargesMultiYear();
        } elseif ($n == 2 && $url_a[2] == 'multi-years') {

            return $this->actionSelectDataMultiYears(Yii::$app->request->get('years'), Yii::$app->request->get('user_type'));
        } else {
            return null;
        }
    }

    public function actionGetDataLine()
    {
        $url_a = explode("/", Yii::$app->request->url);
        $param_a = explode("-", $url_a[2]);
        $n = count($param_a);

        if ($n == 3) {
            return $this->actionChargesMonth();
        } elseif ($n == 2 && $url_a[2] != 'select-data') {

            return $this->actionChargesYear();
        } elseif ($n == 2 && $url_a[2] == 'select-data') {
            return $this->actionSelectData();

        } elseif ($n == 1) {
            return 2;
        } else {
            return null;
        }

    }

    public function actionSelectData($year_start = null, $year_end = null, $user_type = null)
    {



        $chargesModel = new Charges();
        $modelChargesForm = new ChargesForm();


        $u = explode('?', Yii::$app->request->url);

        $url_array = explode("/", $u[0]);

        $label = $chargesModel->attributeLabels();
        $date_today = Yii::$app->formatter->asDate('now', 'yyyy');

        $users_type = 5;
        $start_period = ($date_today - 1999) - Yii::$app->params['year-period-select-data'];
        $end_period = ($date_today - 1999);

        if (Yii::$app->request->post()) {
            if (Yii::$app->request->post('ChargesForm')['year_from'] <= Yii::$app->request->post('ChargesForm')['year_to']) {
                $users_type = Yii::$app->request->post('ChargesForm')['users_type'];
                $start_period = Yii::$app->request->post('ChargesForm')['year_from'];
                $end_period = (Yii::$app->request->post('ChargesForm')['year_to'] + 1);


                $modelChargesForm->year_to = ($end_period - 1);
                $modelChargesForm->year_from = $start_period;
                $modelChargesForm->users_type = $users_type;
            } else {
                Yii::$app->session->addFlash('dateHight', 'Дата начала приода должна быть меньше даты окончания периода! Введите данные еще раз.');

            }

        }


        if (isset($year_start) && isset($year_end) && isset($user_type)) {

            $users_type = $user_type;
            $start_period = $year_start.'01';
            $end_period = $year_end.'01';
        }


        $users_type_array = $this->usersType($users_type);

        $user_class_unuse = $users_type_array['user_class_unuse'];// $users_type > 3 ? 1 : 0;

        $data = $this->totalCharges($chargesModel, "Ym", $start_period, $end_period, $users_type_array['net_id_operator'], $users_type_array['net_id'], $users_type_array['user_class'], $user_class_unuse, $users_type_array['additional_condition']);
        $chart_name_year = 'charges_by_network_all';

        $graph_name = $users_type_array['name'] . '. Период с  ' . ((int)$start_period + 2000) . '-01 по, ' . ((int)$end_period + 1999) . '-12.';

        $max_y_scale = (max($data['data_charge']) < 600 && max($data['data_charge']) > 200) ? 600 : (max($data['data_charge']) + 50);

        $text_angle = count($data['data']) < 15 ? 0 : 90;
        $this->chartCreater3($users_type_array['name_file'], $graph_name, $data['data_charge'], $data['data_time'], 'Выручка, тысяч грн', 'Дата', 'Y-m', $max_y_scale, $text_angle, Yii::$app->params['colors_statistic'][$users_type]);

        if (isset($url_array[3])) {
            $line = null;
            if ($url_array[3] == 'table') {
                $views_name = 'get_data_table';
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
        for ($i = 2007; $i <= ($date_today); $i++) {
            $years_array[$i - 2000] = $i;
        }
        $users_type_a = array();
        for ($i = 1; $i <= 7; $i++) {
            $users_type_a[$i] = $this->usersType($i)['name'];
        }



        return $this->render($views_name, [
            'label' => $label,
            'chart_name_year' => $chart_name_year,
            'data' => $data['data'],
            //  'year' => $param_array[1],
            'user_type' => $users_type,
            'name' => $users_type_array['name'],
            'name_file' => $users_type_array['name_file'],
            'menu_items_years' => $this->getMenuItemsYears($users_type),
            'start_period' => $start_period,
            'end_period' => $end_period,
            'model_charges_form' => $modelChargesForm,
            'years_array' => $years_array,
            'users_type_a' => $users_type_a
        ]);
    }

    public function actionChargesMultiYear()
    {
        $url_array = explode("/", Yii::$app->request->url);
        $year_array = explode("-", $url_array[3]);
        // print_r($param_array);
        $year_start_array = explode("-", Yii::$app->params['date-before']);
        $start_period = ($year_start_array[0] - 2000);

        $end_period = (Yii::$app->formatter->asDate('now', 'yyyy') - 1999);

        $users_type = $this->usersType($url_array[2]);


        $user_class_unuse = $users_type['user_class_unuse'];//  $url_array[2] > 3 ? 1 : 0;

        //print_r($year_start);


        $chargesModel = new Charges();


        $label = $chargesModel->attributeLabels();

        $graph_name = $users_type['name'] . ', ' . $url_array[3] . ' год';
        $chart_name_year = 'charges_by_network_all';
        /**
         * if (isset($url_array[3]) && $url_array[3] == 'line') {
         * $data_year = $this->totalCharges($chargesModel, "Ymd", $start_period, $end_period, $users_type['net_id_operator'], $users_type['net_id'], $users_type['user_class'], $user_class_unuse);
         *
         * $this->chartCreater2($users_type['name_file'], $graph_name, $data_year['data_charge'], $data_year['data_time'], 'Выручка, тысяч грн', 'Дата', 'Y-m-d', 60, 90, $this->colors[$url_array[2]], 7);
         *
         * $data_table_array = array();
         *
         * } else {
         * */
        $data_year = $this->totalCharges($chargesModel, "Ym", $start_period, $end_period, $users_type['net_id_operator'], $users_type['net_id'], $users_type['user_class'], $user_class_unuse, $users_type['additional_condition']);

        $data_year_f_s = $this->multiYearsDataParsing($data_year['data'], $start_period, $end_period);
        $data_years_simple = $data_year_f_s['simple'];
        $data_years_full = $data_year_f_s['full'];

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
        $data_max_array = array();
        foreach ($data_y_array as $v) {
            $data_max_array[] = max($v);
        }
        $max_data = max($data_max_array);

        $max_y_scale = ($max_data < 600 && $max_data > 200) ? 600 : ($max_data + 50);

        $this->chartCreater5($users_type['name_file'], $graph_name, $data_y_array, $data_time, 'Выручка, тысяч грн', 'Дата, месяц', $max_y_scale, 0);
        //    }

        $line = 0;
        if (isset($url_array[4])) {
            if ($url_array[4] == 'table') {
                $views_name = 'get_data_table';
            } elseif ($url_array[4] == 'line') {
                $views_name = 'charges_multi_year';
                $line = 1;
            } else {
                $views_name = 'charges_multi_year';
            }
        } else {
            $views_name = 'charges_multi_year';
        }
        //die('ups');


        return $this->render($views_name, [
            'label' => $label,
            'chart_name_year' => $chart_name_year,
            'data' => $data_table_array,
            'year_string' => $url_array[3],
            'user_type' => $url_array[2],
            'name' => $users_type['name'],
            'name_file' => $users_type['name_file'],
            'menu_items_years' => $this->getMenuItemsYears($url_array[2], $year_array, $line),
            'date_today' => ((int)$end_period + 1999)

            //       'line' => $line
        ]);

    }

    public function actionSelectDataMultiYears($years_get = null, $user_type_get = null)
    {
        $chargesModel = new Charges();
        $modelMultiYearsForm = new MultiYearsForm();
        $u = explode('?', Yii::$app->request->url);

        $url_array = explode("/", $u[0]);


        $label = $chargesModel->attributeLabels();
        $date_today = Yii::$app->formatter->asDate('now', 'yyyy');
        $year_array = array();


        $year_start_array = explode("-", Yii::$app->params['date-before']);
        $start_period = ($year_start_array[0] - 2000);


        $end_period = (Yii::$app->formatter->asDate('now', 'yyyy') - 1999);

        $years_array_full = array();
        for ($i = $year_start_array[0]; $i <= ((int)$end_period + 1999); $i++) {
            $years_array_full[] = $i;
        }


        if (Yii::$app->request->post()) {
            $users_ty = Yii::$app->request->post('MultiYearsForm')['users_type'];
            $year_array = Yii::$app->request->post('MultiYearsForm')['years'];

            $modelMultiYearsForm->users_type = $users_ty;

        } elseif (isset($years_get) && isset($user_type_get)) {


            $users_ty = $user_type_get;
            $year_array = explode('-', $years_get);


        } else {
            $users_ty = 5;
            $years_number = Yii::$app->params['years-compare'];

            $year_array = array_slice($years_array_full, -$years_number);

            sort($year_array);

        }
        $users_type = $this->usersType($users_ty);

        $years_string = '';
        foreach ($year_array as $v) {
            $years_string .= $v . '-';
        }
        $years_string = trim($years_string, '-');


        $user_class_unuse = $users_type['user_class_unuse'];// $users_ty > 3 ? 1 : 0;

        $graph_name = $users_type['name'] . ', ' . $years_string . ' год';
        $chart_name_year = 'charges_by_network_all';

        $data_year = $this->totalCharges($chargesModel, "Ym", $start_period, $end_period, $users_type['net_id_operator'], $users_type['net_id'], $users_type['user_class'], $user_class_unuse, $users_type['additional_condition']);

        $data_year_f_s = $this->multiYearsDataParsing($data_year['data'], $start_period, $end_period);
        $data_years_simple = $data_year_f_s['simple'];
        $data_years_full = $data_year_f_s['full'];

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

        $data_max_array = array();
        foreach ($data_y_array as $v) {
            $data_max_array[] = max($v);
        }
        $max_data = max($data_max_array);

        $max_y_scale = ($max_data < 600 && $max_data > 200) ? 600 : ($max_data + 50);

        $this->chartCreater5($users_type['name_file'], $graph_name, $data_y_array, $data_time, 'Выручка, тысяч грн', 'Дата, месяц', $max_y_scale, 0);


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

        $users_type_a = array();
        for ($i = 1; $i <= 7; $i++) {
            $users_type_a[$i] = $this->usersType($i)['name'];
        }

        $year_year_array_full = array();
        foreach ($years_array_full as $v) {
            $year_year_array_full[$v] = $v;
        }

        return $this->render($views_name, [
            'label' => $label,
            'chart_name_year' => $chart_name_year,
            'data' => $data_table_array,
            'year_string' => $years_string,
            'user_type' => $users_ty,
            'name' => $users_type['name'],
            'name_file' => $users_type['name_file'],
            'menu_items_years' => $this->getMenuItemsYears($users_ty, $year_array, $line),
            'model_multi_years_form' => $modelMultiYearsForm,
            'year_array' => $year_year_array_full,
            'users_type_a' => $users_type_a,
            'url_part_2' => $url_array[2],
            'date_today' => $date_today
            //       'line' => $line
        ]);


    }


}