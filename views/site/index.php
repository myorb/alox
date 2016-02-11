<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Привет</h1>

        <p class="lead">Это маленький адон к olx. Он помогает искать обявления на <b>olx</b></p>

        <p><a class="btn btn-lg btn-success" href="/query">Add You Query</a></p>
    </div>


    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Шаг 1</h2>
                <p>Регистрируешся</p>

                <p><?= \yii\helpers\Html::a('Login','login')?></p>


            </div>
            <div class="col-lg-4">
                <h2>Шаг 2</h2>
                <p>Копируеш url из олх</p>

                <p><?= \yii\helpers\Html::a('query','/query')?></p>

            </div>
            <div class="col-lg-4">
                <h2>Это все )</h2>

                <p>Обновляеш интересные предложения.</p>

                <p><?= \yii\bootstrap\Html::a("Apartments",'/apartment')?></p>
            </div>
        </div>

    </div>
</div>
