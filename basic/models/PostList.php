<?php
namespace app\models;
use yii\base\Model;

class PostList extends Model{

    public $header;
    public $text;
    public $date;
    public $category_id = '';
    public $user_id = '';
    public $category = '';
    public $user = '';
    public $order_by = 'Date DESC';
    public $search = '';

    public function rules()
    {
        return [
            [['order_by', 'category', 'user'], 'required', 'message' => 'Field is required'],
            ['search', 'string']
        ];
    }

    public function attributeLabels()
    {
        return [
            'order_by' => 'Select Post order',
        ];
    }
}