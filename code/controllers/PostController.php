<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\Post;
use app\models\User;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\PostForm;
use yii\base\Exception as YiiException;

class PostController extends Controller
{
    /**
     * @return Response|string
     */
    public function actionCreate(): Response|string
    {
        $error = null;

        try {
            if (Yii::$app->user->isGuest) {
                return $this->redirect('/site/login');
            }
            $user = (new User())->findIdentity(Yii::$app->user->getId());

            if (!$user->isAdmin()) {
                return $this->redirect('/');
            }

            $model = new PostForm();
            if ($model->load(Yii::$app->request->post())) {
                if ($post = $model->createPost()) {
                    return $this->redirect('/post/detail?id=' . $post->getId());
                }
            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }

        return $this->render('create', [
            'model' => $model,
            'error' => $error
        ]);
    }

    /**
     * @return string|void
     */
    public function actionDetail()
    {
        try {
            $postId = (int)$_GET['id'] ?? null;
            if ($postId === null) {
                throw new YiiException("Post not found.");
            }
            $post = (new Post())->findIdentity($postId);

            if ($post === null) {
                throw new YiiException("Post not found.");
            }

            if ($post->isForAuthorizationUser() && Yii::$app->user->isGuest) {
                throw new YiiException("This article only for authorization users!");
            }

        } catch (YiiException $e) {
            print $e->getMessage();
            die();
        }

        return $this->render('detail', [
            'post' => $post
        ]);
    }
}
