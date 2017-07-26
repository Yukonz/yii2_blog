<?php
namespace app\models;
use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class RegisterForm extends Model{

    public $username;
    public $password;
    public $email;
    public $role = 'user';
    public $posts = 0;
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['username', 'password', 'email'], 'required', 'message' => 'Заполните поле'],
            ['email', 'email'],
            ['username', 'unique', 'targetClass' => User::className(),  'message' => 'Этот логин уже занят'],
            ['email', 'unique', 'targetClass' => User::className(),  'message' => 'Этот E-mail уже занят'],
            ['imageFile', 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
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