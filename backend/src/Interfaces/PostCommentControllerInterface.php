<?php

namespace App\Interfaces;

use App\Models\PostComment;
use Psr\Container\ContainerInterface;

interface PostCommentControllerInterface extends ControllerInterface
{
    public function __construct(ContainerInterface $container, PostComment $model);
}