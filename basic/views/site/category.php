<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
    <h4><?php echo $category['name']; ?></h4>
    <hr>
<?php if ($posts){
            foreach ($posts as $post){ ?>
                <?php $post['text'] = substr($post['text'], 0, 40) . '...'; ?>
                <h4><?php echo $post['header'] ?></h4>
                <p><?php echo $post['text'] ?></p>
                <p><?php echo $post['user']['username'] ?></p>
                <p><?php echo $post['date'] ?></p>
                <p class='detail-link'><a href='/site/single_post?id=<?php echo $post['id'] ?>'>Read more</a></p>
                <hr>
            <?php
        }
        ?>
    <?php
}
?>