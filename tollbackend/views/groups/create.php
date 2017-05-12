<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MasterLanguage */

$this->title = 'Attach Group';
$this->params['breadcrumbs'][] = ['label' => 'Attach Group', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-language-create col-xs-8 col-sm-6">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model
    ])
    ?>

</div>
