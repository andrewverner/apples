<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%apple}}`.
 */
class m230608_135304_create_apple_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%apple}}', [
            'id' => $this->primaryKey(),
            'state' => "ENUM('on tree', 'fell', 'rotten') NOT NULL DEFAULT 'on tree'",
            'color' => "ENUM('green', 'red', 'yellow')",
            'volume' => $this->tinyInteger()->notNull()->defaultValue(default: 100),
            'createdAt' => $this->dateTime()->notNull()->defaultExpression(default: 'NOW()'),
            'fellAt' => $this->dateTime(),
            'deletedAt' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%apple}}');
    }
}
