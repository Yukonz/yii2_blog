<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin();
    echo $form->field($model, 'username');
    echo $form->field($model, 'email');
    echo $form->field($model, 'role')->dropdownList(
        ['admin'=>'admin', 'editor'=>'editor', 'user'=>'user']
    );
    echo
        "<div class='form-group'>"
            . Html::submitButton('Edit', ['class' => 'btn btn-success']) .
        "</div>";
ActiveForm::end();