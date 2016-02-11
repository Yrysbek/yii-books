<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\BooksSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="books-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
                'class' => 'form-inline'
                ],

    ]); ?>

    <?= $form->field($model, 'author_id')->dropDownList($authors)->label(false) ?>

    <?= $form->field($model, 'name')->textInput(['placeholder' => 'название'])->label(false) ?>
    <br>
    <?= $form->field($model, 'from_date')->textInput(['placeholder' => '31/12/2014']) ?>

    <?= $form->field($model, 'to_date')->textInput(['placeholder' => '31/12/2015']) ?>
    <br>
    <?= Html::submitButton('Искать', ['class' => 'btn btn-primary']) ?>

    <?php ActiveForm::end(); ?>

</div>
