<?php

declare(strict_types=1);

namespace Migrations;

use Phoenix\Database\Element\ColumnSettings;
use Phoenix\Exception\InvalidArgumentValueException;
use Phoenix\Migration\AbstractMigration;

final class Posts extends AbstractMigration
{
    /**
     * @throws InvalidArgumentValueException
     */
    protected function up(): void
    {
        $this->table('posts')
            ->addColumn('id', 'integer', [
                ColumnSettings::SETTING_AUTOINCREMENT => true
            ])
            ->addColumn('user_id', 'integer', [
                ColumnSettings::SETTING_NULL => false
            ])
            ->addColumn('title', 'string', [
                ColumnSettings::SETTING_NULL => false
            ])
            ->addColumn('content', 'mediumtext', [
                ColumnSettings::SETTING_NULL => false
            ])
            ->create();
    }

    protected function down(): void
    {
        $this->table('posts')->drop();
    }
}
