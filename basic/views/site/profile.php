<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

echo "<img class='avatar-profile' src='/avatars/avatar_" . Yii::$app->user->identity->id . ".jpg'>";
echo
    "<h2>"       . $model->username . "</h2>
    <hr>
    <h4>Role: "  . $model->role . "</h4>
    <hr>
    <h4>Posts: " . $model->posts . "</h4>
    <hr>";

$form = ActiveForm::begin();
    echo $form->field($model, 'password')->passwordInput();
    echo $form->field($model, 'email');
    echo $form->field($model, 'imageFile')->fileInput()->label('Select avatar image');
    echo
        "<div class='form-group'>"
            . Html::submitButton('Edit', ['class' => 'btn btn-success']) .
        "</div>";
ActiveForm::end();