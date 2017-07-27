<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$form = ActiveForm::begin();
    echo $form->field($model, 'username')->label('Login');
    echo $form->field($model, 'password')->passwordInput()->label('Password');
    echo $form->field($model, 'email')->label('Email');
    echo $form->field($model, 'imageFile')->fileInput()->label('Select avatar image (jpg only)');
    echo $form->field($model, 'verifyCode')->widget(Captcha::className(), [
        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
    ]);
    echo
        "<div class='form-group'>"
                . Html::submitButton('Registration', ['class' => 'btn btn-success']) .
        "</div>";
ActiveForm::end();