<?php
namespace app\models;
use yii\base\Model;

class EditUserForm extends Model{

    public $username;
    public $email;
    public $posts;
    public $role;

    public function rules()
    {
        return [
            [['username', 'email', 'role'], 'required', 'message' => 'Заполните поле'],
            ['email', 'email'],
//            ['username', 'unique', 'targetClass' => User::className(),  'message' => 'Этот логин уже занят'],
//            ['email', 'unique', 'targetClass' => User::className(),  'message' => 'Этот E-mail уже занят'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Login',
            'email' => 'E-mail',
            'role' => 'Role',
        ];
    }
}