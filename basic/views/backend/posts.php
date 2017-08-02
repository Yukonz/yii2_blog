<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;

?>
    <ul class='nav nav-tabs'>
        <li class='active'><a href='/backend/posts'>Posts</a></li>
        <li><a href='/backend/categories'>Categories</a></li>
        <li><a href='/backend/users'>Users</a></li>
        <?php
        if (\Yii::$app->user->can('editComment')) {
            echo "<li><a href='/backend/comments'>Comments</a></li>";
        }
        ?>
    </ul>
    <hr>
    <h4>Post list:</h4>

<?php
if ((\Yii::$app->user->can('createPost'))&&((\Yii::$app->user->can('unlimitedPosts'))||($posts_count<5))) {
    echo "<a href='/backend/post_add' class='btn btn-primary'>New Post</a></td>";
}

if ($posts){
    echo
        "<table class='table'>
            <tr>
                <td>ID</td>
                <td>Header</td>
                <td>Text</td>
                <td>Category</td>
                <td>User</td>
                <td>Date</td>
                <td>Edit</td>
                <td>Delete</td>
            </tr>";

        foreach ($posts as $post){
            $post['text'] = substr($post['text'], 0, 40) . '...';
            echo
                "<tr>
                    <td>" . $post['id']               . "</td>
                    <td>" . $post['header']           . "</td>
                    <td>" . $post['text']             . "</td>
                    <td>" . $post['category']['name'] . "</td>
                    <td>" . $post['user']['username'] . "</td>
                    <td>" . $post['date']             . "</td>
                    <td><a href='/backend/post_edit?id=" . $post['id'] . "' class='btn btn-success edit'>Edit</a></td>
                    <td><a href='/backend/post_delete?id=" . $post['id'] . "' class='btn btn-danger delete'>Delete</a></td>
                </tr>";
        }
    echo "</table>";
    echo LinkPager::widget(['pagination' => $pagination]);

    $form = ActiveForm::begin(['action' => ['posts'], 'id' => 'order-by-form', 'options' => ['class' => 'form-horizontal'],]);
        echo $form->field($model, 'search')->textInput(['maxlength' => 20, 'class' => 'form-control input-sm']);
        echo
            "<div class='form-group'>"
            . Html::submitButton('Search', ['class' => 'btn btn-primary']) .
            "</div>";
    ActiveForm::end();

    $form = ActiveForm::begin(['id' => 'order-by-form', 'options' => ['class' => 'form-horizontal'],]);
        echo $form->field($model, 'order_by')->dropdownList(
            ['date DESC'=>'Date', 'header'=>'Header', 'text'=>'Text', 'category_id'=>'Category', 'user_id'=>'User']
            )->label('Order posts by:');

        echo $form->field($model, 'category')->dropdownList(
            $categories_list
            )->label('View posts from category:');

        echo $form->field($model, 'user')->dropdownList(
            $users_list
            )->label('View posts from user:');

        echo
            "<div class='form-group'>"
            . Html::submitButton('Sort', ['class' => 'btn btn-primary']) .
            "</div>";
    ActiveForm::end();
}