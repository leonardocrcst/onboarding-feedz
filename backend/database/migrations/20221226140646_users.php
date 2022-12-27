<?php

declare(strict_types=1);

namespace Migrations;

use Phoenix\Database\Element\ColumnSettings;
use Phoenix\Exception\InvalidArgumentValueException;
use Phoenix\Migration\AbstractMigration;

final class Users extends AbstractMigration
{
    /**
     * @throws InvalidArgumentValueException
     */
    protected function up(): void
    {
        $this->table('users')
            ->addColumn('id', 'integer', [
                ColumnSettings::SETTING_AUTOINCREMENT => true
            ])
            ->addColumn('email', 'string', [
                ColumnSettings::SETTING_NULL => false,
            ])
            ->addColumn('password', 'string', [
                ColumnSettings::SETTING_NULL => false
            ])
            ->create();
    }

    protected function down(): void
    {
        $this->table('users')->drop();
    }
}
