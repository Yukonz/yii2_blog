<?php
namespace app\models;
use yii\base\Model;

class ProfileForm extends Model{

    public $username;
    public $password;
    public $email;
    public $posts = 0;
    public $role = 'user';

    public function rules()
    {
        return [
            [['username', 'password', 'email'], 'required', 'message' => 'Заполните поле'],
            ['email', 'email'],
//            ['username', 'unique', 'targetClass' => User::className(),  'message' => 'Этот логин уже занят'],
//            ['email', 'unique', 'targetClass' => User::className(),  'message' => 'Этот E-mail уже занят'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
        ];
    }
}