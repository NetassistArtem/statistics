<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>


    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'NETassist statistics',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);


    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],

        'items' => [
            //  ['label' => 'Home', 'url' => ['/site/index']],
            // ['label' => 'About', 'url' => ['/site/about']],
            //   ['label' => 'Contact', 'url' => ['/site/contact']],
            //   ['label' => 'Test', 'url' => ['/users/index']],
            ['label' => 'Финансовая статистика', 'url' => '/charges',
                'active' => (
                    Yii::$app->request->url == "/charges" ||
                    preg_match("/\/charges\/\d{1}-\d{4}/", Yii::$app->request->url) ||
                    Yii::$app->request->url == "/charges/select-data" ||
                    Yii::$app->request->url == "/charges/multi-years"
                ),
                'items' => [
                    ['label' => 'Общие графики', 'url' => '/charges',],
                    ['label' => 'Детальные графики', 'url' => '/charges/5-2016',],
                    ['label' => 'График с выбором периода', 'url' => '/charges/select-data',],
                    ['label' => 'График сравнение по годам', 'url' => '/charges/multi-years',],

//                ['label' => 'Домашние', 'url' => 'charges',],
//                ['label' => 'Бизнес-домосеть', 'url' => 'charges#business_homenetwork',],
//                ['label' => 'Бизнес-магистральные', 'url' => 'charges#business_trunk'],
//                ['label' => 'Домосеть', 'url' => 'charges#homenetwork'],
//                ['label' => 'Все', 'url' => 'charges#all']
                ]
            ],
            ['label' => 'Статистика TODO', 'url' => '/todo','encodeLabels' => 'true',
                'active' => (
                    Yii::$app->request->url == "/todo" ||
                    preg_match("/\/todo\/\d{1}-\d{4}/", Yii::$app->request->url) ||
                    preg_match("/\/todo\/\d{1}/", Yii::$app->request->url) ||
                    Yii::$app->request->url == "/todo/select-data" ||
                    preg_match("/\/todo-time\/\d{1}-\d{4}-\d{1,2}/", Yii::$app->request->url) ||
                    Yii::$app->request->url == "/todo-time/select-data" ||
                    Yii::$app->request->url == "/todo-time/select-data/two-columns"
                ),
                'items' => [
                    '<li class="dropdown-header">Количесто TODO</li>',
                    ['label' => 'Графики за весь период', 'url' => '/todo/2',],
                    ['label' => 'Детальные графики', 'url' => '/todo/2-2016',],
                    ['label' => 'График с выбором периода', 'url' => '/todo/select-data',],

                    '<li class="divider"></li>',
                    '<li class="dropdown-header">Время обработки TODO</li>',
                    ['label' => 'Детальные графики', 'url' => '/todo-time/'.Yii::$app->params["default_value"]["todo_time"]["year_todo_type"].'-'.Yii::$app->formatter->asDate("now", "yyyy").'-'.Yii::$app->params["default_value"]["todo_time"]["year_todo_status"],],
                    ['label' => 'График с выбором периода', 'url' => '/todo-time/select-data',],


                ],
            ],
            Yii::$app->user->isGuest ? (
            ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>


    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; NETassist statistics <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
