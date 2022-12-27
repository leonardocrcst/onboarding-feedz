<?php

declare(strict_types=1);

namespace Migrations;

use Phoenix\Database\Element\ColumnSettings;
use Phoenix\Exception\InvalidArgumentValueException;
use Phoenix\Migration\AbstractMigration;

final class PostsComments extends AbstractMigration
{
    /**
     * @throws InvalidArgumentValueException
     */
    protected function up(): void
    {
        $this->table('posts_comments')
            ->addColumn('id', 'integer', [
                ColumnSettings::SETTING_AUTOINCREMENT => true
            ])
            ->addColumn('post_id', 'integer', [
                ColumnSettings::SETTING_NULL => false
            ])
            ->addColumn('user_id', 'integer', [
                ColumnSettings::SETTING_NULL => false
            ])
            ->addColumn('comment', 'string', [
                ColumnSettings::SETTING_NULL => false
            ])
            ->create();
    }

    protected function down(): void
    {
        $this->table('posts_comments')->drop();
    }
}
