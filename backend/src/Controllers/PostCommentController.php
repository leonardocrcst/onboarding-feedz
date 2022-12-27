<?php

namespace App\Controllers;

use App\Models\PostComment;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class PostCommentController extends BaseController implements \App\Interfaces\PostCommentControllerInterface
{

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container, PostComment $model)
    {
        $container->get('db')->table('posts_comments');
        $this->model = $model;
    }
}