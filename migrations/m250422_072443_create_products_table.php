<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%products}}`.
 */
class m250422_072443_create_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%products}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->text(),
            'category_id' => $this->integer(),
            'status' => $this->boolean()->defaultValue(1),
            'image' => $this->string(),
        ]);
        $this->addForeignKey(
            'fk-products-category_id',
            'products',
            'category_id',
            'categories',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-products-category_id',
            '{{%products}}'
        );
        $this->dropTable('{{%products}}');
    }
}
