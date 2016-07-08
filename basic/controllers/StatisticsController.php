<?php


namespace app\controllers;

use yii\base\Exception;
use yii\BaseYii;
use yii\web\Controller;
use yii\web\UrlManager;
use app\models\Charges;
use Yii;
use app;
use yii\web\Request;


class StatisticsController extends Controller
{
    private $colors = array(
        1 => array(100, 149, 237),
        2 => array(60, 174, 113),
        3 => array(255, 215, 0),
        4 => array(178, 34, 34),
        5 => array(105, 105, 105),
    );

    private function chartCreater1($file_name, $chart_name, $data_y, $data_x, $name_y, $name_x, $date_format, $max_YAxis, array $color_pallet)
    {
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
        $Test->writeValues($DataSet->GetData(), $DataSet->GetDataDescription(), "series_2");

        // Finish the graph
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 8);
        // $Test->drawLegend(75,35,$DataSet->GetDataDescription(),255,255,255);
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 10);
        $Test->drawTitle(550, 22, $chart_name, 50, 50, 50, 585);
        $Test->Render(__DIR__ . '/../web/images/' . $file_name . '.png');

    }

    private function chartCreater2($file_name, $chart_name, $data_y, $data_x, $name_y, $name_x, $date_format, $max_YAxis)
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
        $Test->setFixedScale(0, $max_YAxis, 10);
        $Test->setDateFormat($date_format);
        //$Test->setFixedScale(0,4200,200);

        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf', 8);
        $Test->setGraphArea(70, 30, 1120, 450);
        $Test->drawFilledRoundedRectangle(7, 7, 1163, 538, 5, 240, 240, 240);
        $Test->drawRoundedRectangle(5, 5, 1165, 540, 5, 230, 230, 230);
        $Test->drawGraphArea(255, 255, 255, TRUE);
        $Test->drawScale($DataSet->GetData(), $DataSet->GetDataDescription(), SCALE_NORMAL, 0, 0, 0, TRUE, 90, 0);
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

    private function chartCreater3($file_name, $chart_name, $data_y, $data_x, $name_y, $name_x, $date_format, $max_YAxis, $text_angle_X, array $color_pallet)
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
        $Test->drawScale($DataSet->GetData(), $DataSet->GetDataDescription(), SCALE_NORMAL, 0, 0, 0, TRUE, $text_angle_X, 0, TRUE);
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

    private function chartCreater4($file_name, $chart_name, $data_y, $data_x, $name_y, $name_x, $date_format,
                                   $max_YAxis, $data_y2, $data_y3, $data_y4, $data_y5)
    {
        include_once(__DIR__ . '/../vendor/pChart/pChart/pData.class');
        include_once(__DIR__ . '/../vendor/pChart/pChart/pChart.class');

        // Dataset definition
        $DataSet = new \pData;

        $DataSet->SetXAxisFormat("date");
        $DataSet->AddPoint($data_x, "series_1");
        $DataSet->AddPoint($data_y2, "series_3");
        $DataSet->AddPoint($data_y, "series_2");

        $DataSet->AddPoint($data_y3, "series_4");
        $DataSet->AddPoint($data_y4, "series_5");
        $DataSet->AddPoint($data_y5, "series_6");

        // $DataSet->ImportFromCSV(__DIR__ . '/../vendor/pChart/Sample/bulkdata.csv',",",array(1,2,3),FALSE,0);
        $DataSet->AddSerie("series_2");
        $DataSet->AddSerie("series_3");
        $DataSet->AddSerie("series_4");
        $DataSet->AddSerie("series_5");
        $DataSet->AddSerie("series_6");
        $DataSet->SetAbsciseLabelSerie("series_1");
        $DataSet->SetSerieName("Все абоненты", "series_2");
        $DataSet->SetSerieName("Домашние абоненты", "series_3");
        $DataSet->SetSerieName("Бизнес-домосеть", "series_4");
        $DataSet->SetSerieName("Бизнес абоненты магистральные", "series_5");
        $DataSet->SetSerieName("Домосеть", "series_6");
        $DataSet->SetYAxisName($name_y);
        $DataSet->SetXAxisName($name_x);


        // Initialise the graph
        $Test = new \pChart(1170, 545);
        $Test->setColorPalette(0, 105, 105, 105);
        $Test->setColorPalette(1, 100, 149, 237);
        $Test->setColorPalette(2, 60, 179, 113);
        $Test->setColorPalette(3, 255, 215, 0);
        $Test->setColorPalette(4, 178, 34, 34);
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
        $Test->writeValues($DataSet->GetData(), $DataSet->GetDataDescription(), array("series_2", "series_3", "series_4", "series_5", "series_6"));

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
                return array(
                    'net_id' => 101,
                    'user_class' => 0,
                    'net_id_operator' => '<',
                    'name' => 'Домашние абоненты',
                    'name_file' => 'charge_year_home'

                );
                break;
            case 2 :
                return array(
                    'net_id' => 199,
                    'user_class' => 1,
                    'net_id_operator' => '<=',
                    'name' => 'Бизнес абоненты с домосетью',
                    'name_file' => 'charge_year_business_homenetwork'
                );
                break;
            case 3 :
                return array(
                    'net_id' => 200,
                    'user_class' => 1,
                    'net_id_operator' => '=',
                    'name' => 'Бизнес абоненты магистральные',
                    'name_file' => 'charge_year_business_trunk'
                );
                break;
            case 4 :
                return array(
                    'net_id' => 199,
                    'user_class' => '',
                    'net_id_operator' => '<=',
                    'name' => 'Домосеть',
                    'name_file' => 'charge_year_homenetwork'
                );
                break;
            case 5 :
                return array(
                    'net_id' => 200,
                    'user_class' => '',
                    'net_id_operator' => '<=',
                    'name' => 'Все абоненты',
                    'name_file' => 'charge_year_all'

                );
                break;
            default:
                return array(
                    'net_id' => 200,
                    'user_class' => '',
                    'net_id_operator' => '<=',
                    'name' => 'Все абоненты',
                    'name_file' => 'charge_year_all'
                );
                break;

        }

    }

    private function getMenuItemsYears($users_type)
    {
        $menu_years_item = array();
        for ($i = 2007; $i <= Yii::$app->formatter->asDate(time(), 'Y'); $i++) {
            $menu_years_item[] = ['label' => "$i", 'url' => "/charges/$users_type-$i", 'active' => "/charges/$users_type-$i" == Yii::$app->request->url];
        }
        //  $menu_years_item[] = ['label' => "Таблица данных", 'url' => Yii::$app->request->url.'/table','options' => ['class' => 'navbar_right_menu']];

        // $menu_years_item[] = '<li> <p><a class="btn btn-success" href="http://www.yiiframework.com">Test</a></p></li>';
        return $menu_years_item;
    }

    private function getMenuItemsMonth($users_type, $year)
    {
        $menu_month_item = array();
        for ($i = 1; $i <= 12; $i++) {

            $i_text = $i < 10 ? '0' . $i : $i;
            $menu_month_item[] = ['label' => "$i_text", 'url' => "/charges/$users_type-$year-$i_text", 'active' => "/charges/$users_type-$year-$i_text" == Yii::$app->request->url];
        }
        return $menu_month_item;
    }

    private function noDataRedirect()
    {
        $url = Yii::$app->request->url;
        $url_array = explode('/', $url);
        $param_array = explode("-", $url_array[2]);
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
        }elseif(isset($param_array[1])){
            $date_request = $param_array[1].'-01';
            $date_request_timestamp = Yii::$app->formatter->asTimestamp($date_request);
            //$date_now_timestamp = Yii::$app->formatter->asTimestamp('now');
            $date_now = Yii::$app->formatter->asDate('now', 'yyyy').'-01';
            $date_now_timestamp = Yii::$app->formatter->asTimestamp($date_now);
            $date_before = Yii::$app->params['date-before'];
            $date_before_array = explode("-", $date_before);
            $date_before = $date_before_array[0] .'-01';
            $date_before_timestamp = Yii::$app->formatter->asTimestamp($date_before);
        }else{
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
    private function totalCharges(Charges $chargesModel, $format, $start_period, $end_period, $net_id_operator, $net_id, $user_class, $user_class_unuse = 0)
    {

        if ($format == 'Y') {
            $date_today = Yii::$app->formatter->asDate(time(), 'Y');
            $date_end_array = str_split($date_today, 2);
            $end_period = $end_period ? $end_period : $date_end_array[1] . +1;
            $scale = "100/100/100/10000";
        } elseif ($format == 'Ym') {
            $date_today = Yii::$app->formatter->asDate(time(), 'Ym');
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

        $data = $chargesModel->ChargesByNetwork($scale, $start_period, $end_period, $net_id_operator, $net_id, $user_class, $user_class_unuse);

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


    public function actionChargesByNetwork()
    {
        $chargesModel = new Charges();
        /*
                $date_today = Yii::$app->formatter->asDate(time(),'Y');
                $date_end_array = str_split($date_today,2);

               $data = $chargesModel->ChargesByNetwork("100/100/100/10000","5",$date_end_array[1]+1,"<",101,0);
              //  print_r($data);

                //print_r($data);
                $data_time = array();
                $data_charge = array();
                foreach($data as $key=>$val){
                    $d = $this->dateParsing($val['ts']);
                   // print_r($data[$val]);
                  //  $data[$key]['ts'] = $d;
                    $data_charge[] = $val['pay']/1000;
                    $data_time[] = $d ; //$val['ts'];

                   // print_r($data_time);
                }
                */


        $data_home = $this->totalCharges($chargesModel, "Y", "5", 0, "<", 101, 0);
        $label = $chargesModel->attributeLabels();
        $chart_name_home = 'charges_by_network_home';
        $color_pallet_home = array(100, 149, 237);
        $this->chartCreater1('charges_by_network_home', "Домашние абоненты", $data_home['data_charge'], $data_home['data_time'], 'Выручка, тысяч грн', 'Дата', 'Y', 4200, $color_pallet_home);

        $data_business_homenetwork = $this->totalCharges($chargesModel, "Y", "5", 0, "<=", 199, 1);
        $chart_name_business_homenetwork = 'charges_by_network_business_homenetwork';
        $color_pallet_business_homenetwork = array(60, 179, 113);
        $this->chartCreater1('charges_by_network_business_homenetwork', "Бизнес абоненты с домосетью", $data_business_homenetwork['data_charge'], $data_business_homenetwork['data_time'], 'Выручка, тысяч грн', 'Дата', 'Y', 4200, $color_pallet_business_homenetwork);

        $data_business_trunk = $this->totalCharges($chargesModel, "Y", "5", 0, "=", 200, 1);
        $chart_name_business_trunk = 'charges_by_network_business_trunk';
        $color_pallet_business_trunk = array(255, 215, 0);
        $this->chartCreater1('charges_by_network_business_trunk', "Бизнес абоненты магистральные", $data_business_trunk['data_charge'], $data_business_trunk['data_time'], 'Выручка, тысяч грн', 'Дата', 'Y', 4200, $color_pallet_business_trunk);

        $data_homenetwork = $this->totalCharges($chargesModel, "Y", "5", 0, "<=", 199, '', 1);
        $chart_name_homenetwork = 'charges_by_network_homenetwork';
        $color_pallet_homenetwork = array(178, 34, 34);
        $this->chartCreater1('charges_by_network_homenetwork', "Домосеть", $data_homenetwork['data_charge'], $data_homenetwork['data_time'], 'Выручка, тысяч грн', 'Дата', 'Y', 4200, $color_pallet_homenetwork);

        $data_all = $this->totalCharges($chargesModel, "Y", "5", 0, "<=", 200, '', 1);
        $chart_name_all = 'charges_by_network_all';
        $color_pallet_all = array(105, 105, 105);
        $this->chartCreater1('charges_by_network_all', "Все абоненты", $data_all['data_charge'], $data_all['data_time'], 'Выручка, тысяч грн', 'Дата', 'Y', 4200, $color_pallet_all);


        $chart_name_allinone = 'charges_by_network_allinone';
        $this->chartCreater4('charges_by_network_allinone', "Все абоненты", $data_all['data_charge'], $data_all['data_time'],
            'Выручка, тысяч грн', 'Дата', 'Y', 4200, $data_home['data_charge'], $data_business_homenetwork['data_charge'], $data_business_trunk['data_charge'], $data_homenetwork['data_charge']);


        return $this->render('charges_by_network', [
            'data_home' => $data_home['data'],
            'label' => $label,
            'chart_name_home' => $chart_name_home,
            'data_business_homenetwork' => $data_business_homenetwork['data'],
            'chart_name_business_homenetwork' => $chart_name_business_homenetwork,
            'chart_name_business_trunk' => $chart_name_business_trunk,
            'data_business_trunk' => $data_business_trunk['data'],
            'chart_name_homenetwork' => $chart_name_homenetwork,
            'data_homenetwork' => $data_homenetwork['data'],
            'chart_name_all' => $chart_name_all,
            'data_all' => $data_all['data'],
            'chart_name_allinone' => $chart_name_allinone,


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

        $user_class_unuse = $param_array[0] > 3 ? 1 : 0;

        //print_r($year_start);


        $chargesModel = new Charges();

        $label = $chargesModel->attributeLabels();

        $data_year = $this->totalCharges($chargesModel, "Ym", $start_period, $end_period, $users_type['net_id_operator'], $users_type['net_id'], $users_type['user_class'], $user_class_unuse);
        $chart_name_year = 'charges_by_network_all';

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

        $graph_name = $users_type['name'] . ', ' . $param_array[1] . ' год';
        $this->chartCreater3($users_type['name_file'], $graph_name, $data_year['data_charge'], $data_year['data_time'], 'Выручка, тысяч грн', 'Дата', 'Y-m', 600, 0, $this->colors[$param_array[0]]);
        if (isset($url_array[3])) {
            if ($url_array[3] == 'table') {
                $views_name = 'get_data_table';
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
            'menu_items_years' => $this->getMenuItemsYears($param_array[0])
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

        $user_class_unuse = $param_array[0] > 3 ? 1 : 0;

        $chargesModel = new Charges();

        $label = $chargesModel->attributeLabels();

        $data_month = $this->totalCharges($chargesModel, "Ymd", $start_period, $end_period, $users_type['net_id_operator'], $users_type['net_id'], $users_type['user_class'], $user_class_unuse);
        $chart_name_year = 'charges_by_network_all';
        /**
         * $day_number = count($data_month['data_time']);
         *
         * if($param_array[2]){
         * $d_y = array();
         * for($i = 0; $i<12; $i++){
         * $i_plus = $i+1;
         *
         *
         * if(($i_plus)<10){
         *
         * $d = Yii::$app->formatter->asTimestamp("$param_array[1]-0$i_plus");
         * }else{
         * $d = Yii::$app->formatter->asTimestamp("$param_array[1]-$i_plus");
         * }
         * if(isset($data_year['data_time'][$i]) && $data_year['data_time'][$i] == $d){
         * $d_y['data_time'][$i] = $d;
         * $d_y['data_charge'][$i] = $data_year['data_charge'][$i];
         * }else{
         * $d_y['data_time'][$i] = $d;
         * $d_y['data_charge'][$i] = '';
         * }
         * }
         * $d_y['data'] = $data_year['data'];
         *
         * $data_year = $d_y;
         * // print_r($data_year);
         * }
         * **/
        $graph_name = $users_type['name'] . ', ' . $param_array[1] . ' год, ' . $param_array[2] . ' месяц';

        $text_angle = count($data_month['data']) < 15 ? 0 : 90;
        $this->chartCreater3($users_type['name_file'], $graph_name, $data_month['data_charge'], $data_month['data_time'], 'Выручка, тысяч грн', 'Дата', 'Y-m-d', 50, $text_angle, $this->colors[$param_array[0]]);
        if (isset($url_array[3])) {
            if ($url_array[3] == 'table') {
                $views_name = 'get_data_table';
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
            'menu_items_month' => $this->getMenuItemsMonth($param_array[0], $param_array[1])
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
        } elseif ($n == 2) {

            return $this->actionChargesYear();
        } elseif ($n == 1) {
            return 2;
        } else {
            return null;
        }


    }

}