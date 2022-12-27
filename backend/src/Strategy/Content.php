<?php

namespace App\Strategy;

use Illuminate\Database\Eloquent\Model;

abstract class Content
{
    public static function prepare(Model $model, array $data): void
    {
        foreach($model->getFillable() as $field) {
            if(array_key_exists($field, $data) && !is_null($data[$field])) {
                $model->setAttribute($field, $data[$field]);
            }
        }
    }
}