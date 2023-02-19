<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="body-content">

        <div class="column">
            <?php /** @var \app\models\Post $post */
            foreach ($posts as $post): ?>
            <div class="col-md">
                <h2><?=$post->getTitle()?></h2>

                <p><?=$post->getDescription()?></p>

                <p><a class="btn btn-outline-secondary" href="/post/detail?id=<?=$post->getId()?>">Read me</a></p>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>
