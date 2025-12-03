<?php

namespace common\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

class Comment extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%comment}}';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules(): array
    {
        return [
            [['post_id', 'author_id', 'content'], 'required'],
            [['post_id', 'author_id', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
        ];
    }

    public function getPost(): ActiveQuery
    {
        return $this->hasOne(Post::class, ['id' => 'post_id']);
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }
}