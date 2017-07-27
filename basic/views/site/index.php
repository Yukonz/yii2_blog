<?php
use yii\widgets\LinkPager;

$this->title = 'My Blog';

echo "<div class='site-index'>";
foreach ($posts as $post){
    $post['text'] = substr($post['text'], 0, 60) . '...';
    echo "<div class='post'>
    <h2>" . $post['header'] . "</h2>
    <p>"  . $post['text'] . "</p>
    <p class='user'>Author: "                              . $post['user']['username'] . "</p>
    <p class='user'>Category: <a href='/site/category?id=" . $post['category']['id'] . "'>" . $post['category']['name'] . "</a></p>
    <p class='date'>"                                      . $post['date'] . "</p>
    <p class='detail-link'><a href='/site/single_post?id=" . $post['id'] . "'>Read more</a></p>
    </div>
    <hr>";
}
echo LinkPager::widget(['pagination' => $pagination]);
echo "</div>";