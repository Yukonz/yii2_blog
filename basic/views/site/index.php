<?php
use yii\widgets\LinkPager;

$this->title = 'My Blog';

echo "<div class='site-index'>";
foreach ($posts as $post){
    $post['text'] = substr($post['text'], 0, 60) . '...';
    echo "
    <div class='panel panel-default'>
      <div class='panel-heading'>" . $post['header'] . "</div>
      <div class='panel-body'>
          <p>"  . $post['text'] . "</p>
      </div>
      <div class='panel-footer'>
            <div class='detail-link'>
                <a href='/site/single_post?id=" . $post['id'] . "'>Read more</a>
            </div>
            <div>
                <p class='date'>"  . $post['date'] . "</p>
                <p class='user'>Author: " . $post['user']['username'] . "</p>
                <p class='user'>Category: <a href='/site/category?id=" . $post['category']['id'] . "'>" . $post['category']['name'] . "</a></p>
            </div>
      </div>
    </div>
";
}
echo LinkPager::widget(['pagination' => $pagination]);
echo "</div>";