<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Category;

$form = ActiveForm::begin(['id' => 'add-post-form', 'options' => ['class' => 'form-horizontal'],]);
    echo $form->field($model, 'header')->label('Post header');
    echo $form->field($model, 'text')->textarea()->label('Post text');
    echo $form->field($model, 'category_id')->dropdownList(
        Category::find()->select(['name', 'id'])->indexBy('id')->column()
    );
    echo
        "<div class='form-group'>"
            . Html::submitButton('Save', ['class' => 'btn btn-primary']) .
        "</div>";
ActiveForm::end();