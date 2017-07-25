<?php
namespace app\models;
use yii\base\Model;

class PostList extends Model{

    public $header;
    public $text;
    public $date;
    public $category_id;
    public $user_id;
    public $order_by = 'Date DESC';

    public function rules()
    {
        return [
            [['order_by'], 'required', 'message' => 'Field is required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'order_by' => 'Select Post order',
        ];
    }
}