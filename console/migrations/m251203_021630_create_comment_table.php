<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comment}}`.
 */
class m251203_021630_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'content' => $this->text()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-comment-post_id', '{{%comment}}', 'post_id');
        $this->createIndex('idx-comment-author_id', '{{%comment}}', 'author_id');

        $this->addForeignKey(
            'fk-comment-post',
            '{{%comment}}',
            'post_id',
            '{{%post}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-comment-author',
            '{{%comment}}',
            'author_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropForeignKey('fk-comment-post', '{{%comment}}');
        $this->dropForeignKey('fk-comment-author', '{{%comment}}');
        $this->dropIndex('idx-comment-post_id', '{{%comment}}');
        $this->dropIndex('idx-comment-author_id', '{{%comment}}');
        $this->dropTable('{{%comment}}');
    }
}
