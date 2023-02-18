<?php

declare(strict_types=1);

namespace app\models;

use Yii;
use yii\base\Model;
use yii\base\Exception as YiiException;

/**
 * @property-read User|null $user
 */
class SignUpForm extends Model
{
    /**
     * @var string
     */
    public $username;
    /**
     * @var string
     */
    public $password;
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $surname;
    /**
     * @var string
     */
    public $repeat_password;

    /**
     * @var bool
     */
    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'name', 'surname', 'password', 'repeat_password'], 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'User with such username already exist'],
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

    /**
     * @return bool
     */
    public function register(): ?User
    {
        $user = new User();
        $this->validateForm();
        $user->setUsername(trim(strtolower($this->username)));
        $user->setName(ucfirst(trim(strtolower($this->name))));
        $user->setSurname(ucfirst(trim(strtolower($this->surname))));
        $user->setPassword($this->password);
        $user->setCreatedAt();
        $user->save();
        return $user;
    }

    /**
     * @return void
     * @throws YiiException
     */
    private function validateForm(): void
    {
        if (mb_strlen($this->username) > 70 || mb_strlen($this->username) < 2 || !preg_match('/[a-z]/i', $this->username)) {
            throw new YiiException("Username more 70 length or less 2");
        }
        if (mb_strlen($this->name) > 70 || mb_strlen($this->name) < 2 || !preg_match('/[a-zA-Z]/i', $this->name)) {
            throw new YiiException("Name more 70 length or less 2");
        }
        if (mb_strlen($this->surname) > 70 || mb_strlen($this->surname) < 2 || !preg_match('/[a-zA-Z]/i', $this->surname)) {
            throw new YiiException("Surname more 70 length or less 2");
        }
        if (mb_strlen($this->password) > 255 || mb_strlen($this->surname) < 2) {
            throw new YiiException("Password more 255 length or less 2");
        }
        if ($this->password != $this->repeat_password) {
            throw new YiiException("Password 1 not equal password 2");
        }
    }
}
