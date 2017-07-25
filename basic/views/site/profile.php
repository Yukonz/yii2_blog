<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<?php $form = ActiveForm::begin() ?>
<?php echo "<h2>" . $model->username . "</h2>"; ?>
<?php echo "<hr>"; ?>
<?php echo "<h4>Role: " . $model->role . "</h4>"; ?>
<?php echo "<hr>"; ?>
<?php echo "<h4>Posts: " . $model->posts . "</h4>"; ?>
<?php echo "<hr>"; ?>
<?php echo $form->field($model, 'password')->passwordInput() ?>
<?php echo $form->field($model, 'email') ?>
<div class="form-group">
    <div>
        <?php echo Html::submitButton('Edit', ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php ActiveForm::end() ?>