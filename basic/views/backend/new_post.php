<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Category;

?>

<?php $form = ActiveForm::begin(['id' => 'add-post-form', 'options' => ['class' => 'form-horizontal'],]); ?>

<?php echo $form->field($model, 'header')->label('Post header') ?>
<?php echo $form->field($model, 'text')->textarea()->label('Post text') ?>


<?php echo $form->field($model, 'category_id')->dropdownList(
    Category::find()->select(['name', 'id'])->indexBy('id')->column()
);

?>

    <div class="form-group">
        <?= Html::submitButton('Add', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>