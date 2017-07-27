<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<ul class='nav nav-tabs'>
    <li><a href='/backend/posts'>Posts</a></li>
    <li class='active'><a href='/backend/categories'>Categories</a></li>
    <li><a href='/backend/users'>Users</a></li>
    <?php if (\Yii::$app->user->can('editComment')) {
        echo "<li><a href='/backend/comments'>Comments</a></li>";
    } ?>
</ul>
    <hr>
    <h4>Categories list:</h4>
<?php if ($categories){
    echo
        "<table class='table'>
            <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Posts</td>";
                if (\Yii::$app->user->can('createCategory')) {
                    echo"<td>Delete</td>";
                }
    echo "</tr>";
    foreach ($categories as $category){
        echo
            "<tr>
                <td>" . $category['id']     . "</td>
                <td>" . $category['name']   . "</td>
                <td>" . $category['posts']  . "</td>";
                if (\Yii::$app->user->can('createCategory')) {
                    echo "<td><a href='/backend/category_delete?id=" . $category['id'] . "' class='btn btn-danger delete'>Delete</a></td>";
                };
        echo "</tr>";
    }

    echo "</table>";
    if (\Yii::$app->user->can('createCategory')) {
        $form = ActiveForm::begin(['id' => 'add-category-form', 'options' => ['class' => 'form-horizontal'],]);
            echo $form->field($model, 'name')->label('Add new category:');
            echo
                "<div class='form-group'>"
                    . Html::submitButton('Add', ['class' => 'btn btn-primary']) .
                "</div>";
        ActiveForm::end();
    }
}
?>