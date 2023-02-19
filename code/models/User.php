<?php

declare(strict_types=1);

namespace app\models;

use yii\db\ActiveRecord;
use Yii;
use yii\base\Exception as YiiException;

/**
 * @property int id
 * @property int is_admin
 * @property string username
 * @property string name
 * @property string surname
 * @property string password
 * @property string created_at
 */
class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @var string
     */
    public $authKey = "Test1111";

    /**
     * @var
     */
    private static $users;

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => strtolower($username)]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return (bool)$this->is_admin;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * @param string $password
     * @return $this
     * @throws YiiException
     */
    public function setPassword(string $password): User
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $surname
     * @return $this
     */
    public function setSurname(string $surname): User
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername(string $username): User
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return $this
     */
    public function setCreatedAt(): User
    {
        $this->created_at = (new \DateTimeImmutable())->format(DATE_ATOM);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->findByUsername(strtolower($this->username))) {
            throw new YiiException("User with such username already exist.");
        }
        return parent::save($runValidation, $attributeNames);
    }
}
