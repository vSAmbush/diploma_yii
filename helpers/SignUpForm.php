<?php

namespace app\helpers;


use app\models\User;
use yii\base\Model;

class SignUpForm extends Model
{
    public $username;
    public $first_name;
    public $second_name;
    public $email;
    public $password1;
    public $password2;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'first_name', 'second_name', 'email', 'password1', 'password2'], 'required'],
            [['username', 'first_name', 'second_name'], 'match', 'pattern' => '/^[a-zа-я_]+$/iu'],
            [['password1', 'password2'], 'match', 'pattern' => '/^[a-z0-9]+$/i'],
            [['username', 'first_name', 'second_name', 'email', 'password1', 'password2'], 'filter', 'filter' => 'trim'],
            [['username', 'first_name', 'second_name', 'password1', 'password2'], 'string', 'min' => 5, 'max' => 40],
            ['email', 'email'],
            ['username', 'unique', 'targetClass' => 'app\models\User'],
            ['email', 'unique', 'targetClass' => 'app\models\User'],
            ['password2', 'compare', 'compareAttribute' => 'password1'],
        ];
    }

    /**
     * Register user
     * @return object $user if all information about user is added to database without errors, else returns null
     */
    public function register() {

        if($this->validate()) { //mandatory inspection
            $user = new User();

            $user->username = $this->username;
            $user->first_name = $this->first_name;
            $user->second_name = $this->second_name;
            $user->email = $this->email;
            $user->status = 1;
            $user->setPassword($this->password1);
            $user->generateAuthKey();

            return $user->save() ? $user : null;
        }

        return false;
    }

    public function attributeLabels()
    {
        return [
            'password1' => 'Password',
            'password2' => 'Repeat password'
        ];
    }
}