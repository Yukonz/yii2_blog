<ul class='nav nav-tabs'>
    <li><a href='/backend/posts'>Posts</a></li>
    <li><a href='/backend/categories'>Categories</a></li>
    <li class='active'><a href='/backend/users'>Users</a></li>
    <?php if (\Yii::$app->user->can('editComment')) {
        echo "<li><a href='/backend/comments'>Comments</a></li>";
    } ?>
</ul>
    <hr>
    <h4>Users list:</h4>

<?php
if ($users){
    echo
        "<table class='table'>
            <tr>
                <td>ID</td>
                <td>Name</td>
                <td>E-mail</td>
                <td>Role</td>
                <td>Posts</td>
                <td>Register date</td>";
                if (\Yii::$app->user->can('editUser')) {
                    echo "
                    <td>Edit</td>
                    <td>Delete</td>";
                };
    echo "</tr>";
    foreach ($users as $user){
        echo
            "<tr>
                <td>" . $user['id']            . "</td>
                <td>" . $user['username']      . "</td>
                <td>" . $user['email']         . "</td>
                <td>" . $user['role']          . "</td>
                <td>" . $user['posts']         . "</td>
                <td>" . $user['register_date'] . "</td>";

        if (\Yii::$app->user->can('editUser')) {
            echo "
                <td><a href='/backend/user_edit?id=" . $user['id'] . "' class='btn btn-success edit'>Edit</a></td>
                <td><a href='/backend/user_delete?id=" . $user['id'] . "' class='btn btn-danger delete'>Delete</a></td>";
        };
        echo "</tr>";
    };
    echo "</table>";
}