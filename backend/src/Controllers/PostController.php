<?php

namespace App\Controllers;

use App\Interfaces\PostControllerInterface;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class PostController extends BaseController implements PostControllerInterface
{

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container, Post $model)
    {
        $container->get('db')->table('users');
        $this->model = $model;
    }

    public function read(int $id = null): array|null|Builder|Collection|Model
    {
        $relations = ['user', 'comments'];
        if ($id) {
            return $this->model->with($relations)->find($id);
        }
        return $this->model->with($relations)->get();
    }
}