<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<?php $form = ActiveForm::begin() ?>
<?php echo $form->field($model, 'username') ?>
<?php echo $form->field($model, 'password')->passwordInput() ?>
<?php echo $form->field($model, 'email') ?>
<?php echo $form->field($model, 'imageFile')->fileInput()->label('Select avatar image') ?>
    <div class="form-group">
        <div>
            <?php echo Html::submitButton('Регистрация', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>