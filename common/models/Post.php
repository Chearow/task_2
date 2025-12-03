<?php

namespace common\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

class Post extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%post}}';
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
            [['title', 'content', 'author_id'], 'required'],
            [['content'], 'string'],
            [['author_id', 'category_id', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }


    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getComments(): ActiveQuery
    {
        return $this->hasMany(Comment::class, ['post_id' => 'id']);
    }
}