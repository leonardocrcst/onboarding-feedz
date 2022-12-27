<?php

namespace App\Controllers;

use App\Interfaces\ControllerInterface;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\User;
use App\Strategy\Content;
use Throwable;

abstract class BaseController implements ControllerInterface
{
    public User | Post | PostComment $model;

    public function create(array $data): User | Post | PostComment | null
    {
        return $this->model::create($data);
    }

    public function read(int $id = null): mixed
    {
        if ($id) {
            return $this->model::find($id);
        }
        return $this->model::all();
    }

    public function update(int $id, array $data): mixed
    {
        $model = $this->model::find($id);
        if ($model) {
            Content::prepare($model, $data);
            return $model->save();
        }
        return 404;
    }

    public function delete(int $id): mixed
    {
        $model = $this->model::find($id);
        if ($model) {
            try {
                return $model->delete();
            } catch (Throwable) {
                return 409;
            }
        }
        return 404;
    }
}