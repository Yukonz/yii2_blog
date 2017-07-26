<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

echo "<h2>" . $post['header'] ."</h2>";
echo "<hr>";
echo "<h4>Author: "   . $post['user']['username'] . "</h4>";
echo "<h4>Date: "     . $post['date']             . "</h4>";
echo "<h4>Category: " . $post['category']['name'] . "</h4>";
echo "<hr>";
echo "<p>" . $post['text'] ."</p>";
echo "<hr>";

$form = ActiveForm::begin() ?>
<?php echo $form->field($model, 'text')->textarea() ?>
<div class="form-group">
    <div>
        <?php echo Html::submitButton('Add comment', ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php ActiveForm::end() ?>

<?php echo "<h4>Comments:</h4>"; ?>

<?php foreach ($comments as $comment){
    echo "<p>" . $comment['text']    . "</p>";
    echo "<p>Author: " . $comment['user']['username'] . "</p>";
    echo "<p>" . $comment['date']    . "</p>";
    echo "<hr>";
}
