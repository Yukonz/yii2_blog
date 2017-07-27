<?php

use yii\widgets\LinkPager;

?>
    <ul class='nav nav-tabs'>
        <li><a href='/backend/posts'>Posts</a></li>
        <li><a href='/backend/categories'>Categories</a></li>
        <li><a href='/backend/users'>Users</a></li>
        <li class='active'><a href='/backend/comments'>Comments</a></li>
    </ul>

    <hr>
    <h4>Comments list:</h4>

<?php if ($comments){
    echo
        "<table class='table'>
            <tr>
                <td>ID</td>
                <td>Author</td>
                <td>Post Header</td>
                <td>Comment</td>
                <td>Date</td>
                <td>Delete</td>
            </tr>";

    foreach ($comments as $comment){
        $comment['post']['header'] = substr($comment['post']['header'], 0, 30) . '...';
        echo
            "<tr>
                <td>" . $comment['id']               . "</td>
                <td>" . $comment['user']['username'] . "</td>
                <td>" . $comment['post']['header']   . "</td>
                <td>" . $comment['text']             . "</td>
                <td>" . $comment['date']             . "</td>
                <td><a href='/backend/comment_delete?id=" . $comment['id'] . "' class='btn btn-danger delete'>Delete</a></td>
            </tr>";
        }
    echo "</table>";
    echo LinkPager::widget(['pagination' => $pagination]);
}