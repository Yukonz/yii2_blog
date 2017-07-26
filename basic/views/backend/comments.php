<?php

use yii\widgets\LinkPager;

?>

    <ul class="nav nav-tabs">
        <li><a href="/backend/posts">Posts</a></li>
        <li><a href="/backend/categories">Categories</a></li>
        <li><a href="/backend/users">Users</a></li>
        <li class="active"><a href="/backend/comments">Comments</a></li>
    </ul>

    <hr>
    <h4>Comments list:</h4>

<?php if ($comments){ ?>
    <table class="table">
        <tr>
            <td>ID</td>
            <td>Author</td>
            <td>Post Header</td>
            <td>Comment</td>
            <td>Date</td>
            <td>Delete</td>
        </tr>
        <?php

        foreach ($comments as $comment){ ?>
            <?php $comment['post']['header'] = substr($comment['post']['header'], 0, 30) . '...'; ?>
            <tr>
                <td><?php echo $comment['id'] ?></td>
                <td><?php echo $comment['user']['username'] ?></td>
                <td><?php echo $comment['post']['header'] ?></td>
                <td><?php echo $comment['text'] ?></td>
                <td><?php echo $comment['date'] ?></td>
                <td><a href='/backend/comment_delete?id= <?php echo $comment['id'] ?> ' class='btn btn-danger delete'>Delete</a></td>
            </tr>
            <?php
        }
        ?>
    </table>

    <?php echo LinkPager::widget(['pagination' => $pagination]);
}
?>