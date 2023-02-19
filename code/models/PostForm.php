<?php

declare(strict_types=1);

namespace app\models;

use Yii;
use yii\base\Model;
use yii\base\Exception as YiiException;

/**
 * @property-read Post|null $post
 */
class PostForm extends Model
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $description;
    /**
     * @var int
     */
    public $is_for_authorization_user;

    /**
     * @var bool
     */
    private $_post = null;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['title', 'description', 'is_for_authorization_user'], 'required'],
        ];
    }

    /**
     * Finds post by id
     *
     * @return Post|null
     */
    public function getPost(): ?Post
    {
        if ($this->_post === null) {
            $this->_post = Post::findIdentity($this->id);
        }

        return $this->_post;
    }

    /**
     * @return Post|null
     */
    public function createPost(): ?Post
    {
        $post = new Post();
        $post->setTitle(trim($this->title));
        $post->setDescription(trim($this->description));
        $post->setIsForAuthorizationUser((int)$this->is_for_authorization_user);
        $post->setCreatedAt();
        $post->save();

        return $post;
    }
}
