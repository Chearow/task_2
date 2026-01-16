<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post_tag}}`.
 */
class m251227_004049_create_post_tag_table extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('{{%post_tag}}', [
            'post_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('pk_post_tag', '{{%post_tag}}', ['post_id', 'tag_id']);

        $this->addForeignKey(
            'fk_post_tag_post_id',
            '{{%post_tag}}',
            'post_id',
            '{{%post}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_post_tag_tag_id',
            '{{%post_tag}}',
            'tag_id',
            '{{%tag}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown(): void
    {
        $this->dropForeignKey('fk_post_tag_post_id', '{{%post_tag}}');
        $this->dropForeignKey('fk_post_tag_tag_id', '{{%post_tag}}');
        $this->dropPrimaryKey('pk_post_tag', '{{%post_tag}}');

        $this->dropTable('{{%post_tag}}');
    }
}
