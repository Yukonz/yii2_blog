<?php

namespace app\models;

use yii\db\ActiveRecord;

class Comment extends ActiveRecord
{
    public static function tableName()
    {
        return '{{comments}}';
    }

    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}