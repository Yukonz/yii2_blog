<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;

?>

    <ul class="nav nav-tabs">
        <li class="active"><a href="/backend/posts">Posts</a></li>
        <li><a href="/backend/categories">Categories</a></li>
        <li><a href="/backend/users">Users</a></li>
    </ul>

    <hr>
    <h4>Post list:</h4>

<?php if (\Yii::$app->user->can('createPost')) {
    echo "<a href='/backend/post_add' class='btn btn-primary'>New Post</a></td>";
} ?>

<?php if ($posts){ ?>
    <table class="table">
        <tr>
            <td>ID</td>
            <td>Header</td>
            <td>Text</td>
            <td>Category</td>
            <td>User</td>
            <td>Date</td>
            <td>Edit</td>
            <td>Delete</td>
        </tr>
        <?php

        foreach ($posts as $post){ ?>
            <?php $post['text'] = substr($post['text'], 0, 40) . '...'; ?>
            <tr>
                <td><?php echo $post['id'] ?></td>
                <td><?php echo $post['header'] ?></td>
                <td><?php echo $post['text'] ?></td>
                <td><?php echo $post['category']['name'] ?></td>
                <td><?php echo $post['user']['username'] ?></td>
                <td><?php echo $post['date'] ?></td>
                <td><a href='/backend/post_edit?id= <?php echo $post['id'] ?> ' class='btn btn-success edit'>Edit</a></td>
                <td><a href='/backend/post_delete?id= <?php echo $post['id'] ?> ' class='btn btn-danger delete'>Delete</a></td>
            </tr>
            <?php
        }
        ?>
    </table>

    <?= LinkPager::widget(['pagination' => $pagination]) ?>

<?php $form = ActiveForm::begin(['id' => 'order-by-form', 'options' => ['class' => 'form-horizontal'],]); ?>

    <?php echo $form->field($model, 'order_by')->dropdownList(
        ['header'=>'header', 'text'=>'text', 'category_id'=>'category_id', 'user_id'=>'user_id', 'date DESC'=>'date']
        );

    ?>

    <div class="form-group">
        <?= Html::submitButton('Sort', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end();

}
?>