<?php

namespace App\Controllers;

use App\Interfaces\UserControllerInterface;
use App\Models\User;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class UserController extends BaseController implements UserControllerInterface
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container, User $model)
    {
        $container->get('db')->table('users');
        $this->model = $model;
    }
}