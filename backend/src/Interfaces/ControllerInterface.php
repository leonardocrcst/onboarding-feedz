<?php

namespace App\Interfaces;

interface ControllerInterface
{
    public function create(array $data): mixed;
    public function read(int $id = null): mixed;
    public function update(int $id, array $data): mixed;
    public function delete(int $id): mixed;
}