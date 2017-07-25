<?php
namespace app\models;
use yii\base\Model;

class AddCommentForm extends Model{

    public $text;
    public $date;
    public $user_id;
    public $post_id;

    public function rules()
    {
        return [
            ['text', 'required', 'message' => 'Field is required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'text' => 'Comment text',
        ];
    }
}