<?php



namespace app\controllers;



use yii\web\Controller;

use app\models\Users;



class UsersController extends Controller
{
    public function actionIndex()
    {
        //include "pChart/pChart/pData.class";
        //include("pChart/pChart/pChart.class");


        $query = Users::find();
        $us = new Users();
        $label = $us->attributeLabels();



        $users = $query->orderBy('switch_id')->all();
        $g_array = array();
        foreach($users as $user){
            $g_array['user_id'][] = $user->id;
            $g_array['switch_id'][] = $user->switch_id;
        }










        include(__DIR__ . '/../vendor/pChart/pChart/pData.class');
        include(__DIR__ . '/../vendor/pChart/pChart/pChart.class');

        // Dataset definition
        $DataSet = new \pData;
        $DataSet->AddPoint($g_array["user_id"],"user_id");
        $DataSet->AddPoint($g_array["switch_id"],"switch_id");
       // $DataSet->ImportFromCSV(__DIR__ . '/../vendor/pChart/Sample/bulkdata.csv',",",array(1,2,3),FALSE,0);
        $DataSet->AddSerie("user_id");
        $DataSet->SetAbsciseLabelSerie("switch_id");
      //  $DataSet->SetSerieName("January","Serie1");
        //$DataSet->SetSerieName("February","Serie2");
       // $DataSet->SetSerieName("March","Serie3");
        $DataSet->SetYAxisName("ID свич");
        $DataSet->SetXAxisName("ID пользователя");


        // Initialise the graph
        $Test = new \pChart(700,230);
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf',8);
        $Test->setGraphArea(70,30,680,200);
        $Test->drawFilledRoundedRectangle(7,7,693,223,5,240,240,240);
        $Test->drawRoundedRectangle(5,5,695,225,5,230,230,230);
        $Test->drawGraphArea(255,255,255,TRUE);
        $Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2);
        $Test->drawGrid(4,TRUE,230,230,230,50);

        // Draw the 0 line
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf',6);
        $Test->drawTreshold(0,143,55,72,TRUE,TRUE);

        // Draw the line graph
        $Test->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());
        $Test->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),3,2,255,255,255);

        // Finish the graph
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf',8);
        $Test->drawLegend(75,35,$DataSet->GetDataDescription(),255,255,255);
        $Test->setFontProperties(__DIR__ . '/../vendor/pChart/Fonts/tahoma.ttf',10);
        $Test->drawTitle(60,22,"example 1",50,50,50,585);
        $Test->Render(__DIR__ . '/../web/images/example1.png');




        return $this->render('index', [
            'users' => $users,
            'label' => $label,
        ]);
    }

}