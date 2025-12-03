<?php

use yii\db\Migration;

class m251203_021608_create_post_table extends Migration
{

    public function safeUp(): void
    {
        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'content' => $this->text()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx_post_author_id', '{{%post}}', 'author_id');
        $this->addForeignKey(
            'fk_post_author',
            '{{%post}}',
            'author_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex('idx_post_category_id', '{{%post}}', 'category_id');
        $this->addForeignKey(
            'fk_post_category_id',
            '{{%post}}',
            'category_id',
            '{{%category}}',
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
        $this->dropForeignKey('fk_post_author', '{{%post}}');
        $this->dropForeignKey('fk_post_category_id', '{{%post}}');
        $this->dropIndex('idx_post_author_id', '{{%post}}');
        $this->dropIndex('idx_post_category_id', '{{%post}}');
        $this->dropTable('{{%post}}');
    }
}
