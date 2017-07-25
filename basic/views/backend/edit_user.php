<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<?php $form = ActiveForm::begin() ?>
<?php echo $form->field($model, 'username') ?>
<?php echo $form->field($model, 'email') ?>
<?php echo $form->field($model, 'role')->dropdownList(
    ['admin'=>'admin', 'editor'=>'editor', 'user'=>'user']
); ?>
    <div class="form-group">
        <div>
            <?php echo Html::submitButton('Edit', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>