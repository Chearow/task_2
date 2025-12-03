<?php

namespace common\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

class Category extends ActiveRecord
{
    public static function tableName(): string{
        return '{{%category}}';
    }

    public function behaviors(): array{
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules(): array{
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    public function getPosts(): ActiveQuery{
        return $this->hasMany(Post::class, ['category_id' => 'id']);
    }
}