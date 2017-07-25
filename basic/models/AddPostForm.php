<?php
namespace app\models;
use yii\base\Model;

class AddPostForm extends Model{

    public $header;
    public $text;
    public $date;
    public $category_id;
    public $user_id;
    public $order_by;

    public function rules()
    {
        return [
            [['header', 'text', 'category_id'], 'required', 'message' => 'Field is required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'header' => 'Header',
            'text' => 'Post text',
            'category_id' => 'Select Post category',
        ];
    }
}