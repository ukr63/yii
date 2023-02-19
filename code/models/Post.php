<?php

declare(strict_types=1);

namespace app\models;

use yii\db\ActiveRecord;
use Yii;
use yii\base\Exception as YiiException;

/**
 * @property int id
 * @property int author_id
 * @property int is_for_authorization_user
 * @property string title
 * @property string description
 * @property string created_at
 */
class Post extends ActiveRecord
{
    /**
     * @var
     */
    private static $posts;

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @param int $id
     * @return Post|null
     */
    public static function findIdentity(int $id)
    {
        return static::findOne($id);
    }

    /**
     * Finds post by title
     *
     * @param string $title
     * @return static|null
     */
    public static function findByTitle(string $title)
    {
        return static::findOne(['title' => strtolower($title)]);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return (int)$this->id;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): Post
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): Post
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param int $authorId
     * @return $this
     */
    public function setAuthorId(int $authorId): Post
    {
        $this->author_id = $authorId;
        return $this;
    }

    /**
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->author_id;
    }

    /**
     * @param int $is_for_authorization_user
     * @return $this
     */
    public function setIsForAuthorizationUser(int $is_for_authorization_user): Post
    {
        $this->is_for_authorization_user = $is_for_authorization_user;
        return $this;
    }

    /**
     * @return bool
     */
    public function isForAuthorizationUser(): bool
    {
        return (bool)$this->is_for_authorization_user;
    }

    /**
     * @return $this
     */
    public function setCreatedAt(): Post
    {
        $this->created_at = (new \DateTimeImmutable())->format(DATE_ATOM);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        return parent::save($runValidation, $attributeNames);
    }
}
