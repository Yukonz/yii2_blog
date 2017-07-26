<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<ul class="nav nav-tabs">
  <li><a href="/backend/posts">Posts</a></li>
  <li class="active"><a href="/backend/categories">Categories</a></li>
  <li><a href="/backend/users">Users</a></li>
    <?php if (\Yii::$app->user->can('editComment')) {
        echo "<li><a href=\"/backend/comments\">Comments</a></li>";
    } ?>
</ul>

<?php if (\Yii::$app->user->can('createCategory')) { ?>
    <?php $form = ActiveForm::begin(['id' => 'add-category-form', 'options' => ['class' => 'form-horizontal'],]); ?>
    <?php echo $form->field($model, 'name')->label('Category name') ?>
        <div class="form-group">
            <?= Html::submitButton('Add', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
    <hr>
<?php } ?>

    <h4>Categories list:</h4>
<?php if ($categories){ ?>
    <table class="table">
        <tr>
            <td>ID</td>
            <td>Name</td>
            <td>Posts</td>
            <?php if (\Yii::$app->user->can('createCategory')) {
                echo"<td>Delete</td>";
            }?>
        </tr>
        <?php
        foreach ($categories as $category){ ?>
            <tr>
                <td><?php echo $category['id'] ?></td>
                <td><?php echo $category['name'] ?></td>
                <td><?php echo $category['posts'] ?></td>
                <?php if (\Yii::$app->user->can('createCategory')) {
                    echo "
                <td><a href='/backend/category_delete?id=" . $category['id'] . "' class='btn btn-danger delete'>Delete</a></td>";
                }; ?>
            </tr>
            <?php
        }
        ?>
    </table>
    <?php
}
?>