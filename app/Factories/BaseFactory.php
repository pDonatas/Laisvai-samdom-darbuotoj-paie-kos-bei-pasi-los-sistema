<?php

namespace App\Factories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseFactory
{
    public function create(array $data, string $class): Model
    {
        $object = new $class();
        foreach($data as $key => $value) {
            $object->$key = $value;
        }

        return $object;
    }

    public function update(Model $class, array $data): Model
    {
        foreach($data as $key => $value) {
            $class->$key = $value;
        }

        return $class;
    }
}
