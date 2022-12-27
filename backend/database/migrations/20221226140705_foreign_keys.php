<?php

declare(strict_types=1);

namespace Migrations;

use Phoenix\Database\Element\ForeignKey;
use Phoenix\Exception\InvalidArgumentValueException;
use Phoenix\Migration\AbstractMigration;

final class ForeignKeys extends AbstractMigration
{
    /**
     * @throws InvalidArgumentValueException
     */
    protected function up(): void
    {
        $this->table('posts')
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                ForeignKey::RESTRICT,
                ForeignKey::CASCADE)
            ->save();
        $this->table('posts_comments')
            ->addForeignKey('user_id',
                'users',
                'id',
                ForeignKey::RESTRICT,
                ForeignKey::CASCADE)
            ->save();
    }

    protected function down(): void
    {
        $this->table('posts')
            ->dropForeignKey('user_id')
            ->save();
        $this->table('posts_comments')
            ->dropForeignKey('user_id')
            ->save();
    }
}
