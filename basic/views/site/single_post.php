<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

echo
    "<h2>" . $post['header'] . "</h2>
    <hr>
    <h4>Author: "   . $post['user']['username'] . "</h4>
    <h4>Date: "     . $post['date']             . "</h4>
    <h4>Category: " . $post['category']['name'] . "</h4>
    <hr>
    <p>"            . $post['text'] ."</p>
    <hr>";

if (!(\Yii::$app->user->getIsGuest())){
    $form = ActiveForm::begin();
        echo $form->field($model, 'text')->textarea();
        echo
            "<div class='form-group'>"
                . Html::submitButton('Add comment', ['class' => 'btn btn-success']) .
            "</div>";
    ActiveForm::end();
}

echo "<h4>Comments:</h4>";

foreach ($comments as $comment){
    echo
        "<p>"                                               . $comment['text']    . "</p>
        <img class='avatar-comments' src='/avatars/avatar_" . $comment['user_id'] . ".jpg'>
        <p>Author: "                                        . $comment['user']['username'] . "</p>
        <p>"                                                . $comment['date']    . "</p>
        <hr>";
}
