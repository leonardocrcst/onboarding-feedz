<?php

namespace App\Interfaces;

use App\Models\Post;
use Psr\Container\ContainerInterface;

interface PostControllerInterface extends ControllerInterface
{
    public function __construct(ContainerInterface $container, Post $model);
}