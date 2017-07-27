<?php
use yii\widgets\LinkPager;

    echo "<h4>" . $category['name'] . "</h4>";
    echo "<hr>";

if ($posts){
    foreach ($posts as $post){
        $post['text'] = substr($post['text'], 0, 40) . '...';
        echo
            "<h4>" . $post['header']           . "</h4>
            <p>"   . $post['text']             . "</p>
            <p>"   . $post['user']['username'] . "</p>
            <p>"   . $post['date']             . "</p>
            <p class='detail-link'><a href='/site/single_post?id=" . $post['id'] . "'>Read more</a></p>
            <hr>";
    }
    echo LinkPager::widget(['pagination' => $pagination]);
}




