<?php

/* @var $this yii\web\View */

use yii\widgets\LinkPager;

$this->title = 'My Blog';
?>
<div class="site-index">

<?php
    foreach ($posts as $post){
        $post['text'] = substr($post['text'], 0, 60) . '...';
        echo "<div class='post'>";
        echo "<h2>{$post['header']}</h2>";
        echo "<p>{$post['text']}</p>";
        echo "<p class='user'>Author: {$post['user']['username']}</p>";
        echo "<p class='user'>Category: {$post['category']['name']}</p>";
        echo "<p class='date'>{$post['date']}</p>";
        echo "<p class='detail-link'><a href='/site/single_post?id=" . $post['id'] . "'>Read more</a></p>";
        echo "</div>";
        echo "<hr>";
    }
?>

<?= LinkPager::widget(['pagination' => $pagination]) ?>

</div>