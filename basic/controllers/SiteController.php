<?php

namespace app\controllers;

use app\components\debugger\Debugger;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionNoData()
    {

        $date_before = Yii::$app->params['date-before'];
        $date_today = Yii::$app->formatter->asDate('now', 'yyyy-MM-dd');

        return $this->render('no-data', ['date_today' => $date_today, 'date_before' => $date_before]);
    }

    public function actionNoDataTodo()
    {

        $date_before = Yii::$app->params['date-before-todo'];
        $date_today = Yii::$app->formatter->asDate('now', 'yyyy-MM-dd');

        return $this->render('no-data', ['date_today' => $date_today, 'date_before' => $date_before]);
    }

    public function actionNoDataInRequest()
    {
        $url = Yii::$app->request->url;
        $url_array = explode('/', $url);
        $param_array = explode("-", $url_array[2]);
        $todo_status = null;
        if (isset($param_array[2])) {
            $request_date = $param_array[1] . '-' . $param_array[2];
        } else {
            $request_date = $param_array[1];

        }
        if ($url_array[1] == 'todo') {
            $todo_type = Yii::$app->params['todo_type'][$param_array[0]]['name'];
        } elseif ($url_array[1] == 'todo-time') {
            if ($url_array[2] == 'select-data') {
                if(Yii::$app->request->post()){
                    $todo_type = Yii::$app->request->post('TodoTimeForm')['todo_type'];
                    $todo_status =  Yii::$app->request->post('TodoTimeForm')['todo_status'];
                    $request_date = Yii::$app->request->post('TodoTimeForm')['year_from'].' - '.(Yii::$app->request->post('TodoTimeForm')['year_to'] + 1);
                }else{
                    $todo_type = Yii::$app->params['todo_type'][2]['name'];
                    $todo_status =  Yii::$app->params['todo_status_for_time'][11]['name'];

                    $date_today = Yii::$app->formatter->asDate('now', 'yyyy');

                    $request_date =($date_today) - Yii::$app->params['year-period-select-data']. ' - '.($date_today);

                }

            } else {


                $todo_type = Yii::$app->params['todo_type'][$param_array[0]]['name'];
                $todo_status = Yii::$app->params['todo_status_for_time'][$param_array[2]]['name'];
                $request_date = $param_array[1];
            }
        } else {
            $todo_type = '';
        }

        return $this->render('no-data-in-request', ['request_date' => $request_date, 'todo_type' => $todo_type, 'todo_status' => $todo_status]);
    }
}
