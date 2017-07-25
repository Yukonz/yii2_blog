<?php
    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;
    use app\models\Category;
?>
<ul class="nav nav-tabs">
  <li><a href="/backend/posts">Posts</a></li>
  <li><a href="/backend/categories">Categories</a></li>
  <li class="active"><a href="/backend/users">Users</a></li>
</ul>

    <h4>User list:</h4>

<?php if ($users){ ?>
    <table class="table">
        <tr>
            <td>ID</td>
            <td>Name</td>
            <td>E-mail</td>
            <td>Role</td>
            <td>Posts</td>
            <td>Register date</td>
            <?php if (\Yii::$app->user->can('editUser')) {
                echo "
            <td>Edit</td>
            <td>Delete</td>";
            }; ?>
        </tr>
        <?php
        foreach ($users as $user){ ?>
            <tr>
                <td><?php echo $user['id'] ?></td>
                <td><?php echo $user['username'] ?></td>
                <td><?php echo $user['email'] ?></td>
                <td><?php echo $user['role'] ?></td>
                <td><?php echo $user['posts'] ?></td>
                <td><?php echo $user['register_date'] ?></td>

                <?php if (\Yii::$app->user->can('editUser')) {
                    echo "
                <td><a href='/backend/user_edit?id=" . $user['id'] . "' class='btn btn-success edit'>Edit</a></td>
                <td><a href='/backend/user_delete?id=" . $user['id'] . "' class='btn btn-danger delete'>Delete</a></td>";
                }; ?>

            </tr>
            <?php
        }
        ?>
    </table>
    <?php
}
?>