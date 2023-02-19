<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\Post $post */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = $post->getTitle();
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-createpost">
    <h1><?=$post->getTitle()?></h1>
    <p>
        <?=$post->getDescription()?>
    </p>
</div>
