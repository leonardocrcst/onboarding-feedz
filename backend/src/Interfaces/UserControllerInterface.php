<?php

namespace App\Interfaces;

use App\Models\User;
use Psr\Container\ContainerInterface;

interface UserControllerInterface extends ControllerInterface
{
    public function __construct(ContainerInterface $container, User $model);
}