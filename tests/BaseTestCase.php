<?php

namespace Tests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class BaseTestCase extends TestCase
{
    public $rules;

    public $validator;

    protected function validate($mockedRequestData)
    {
        return $this->validator
            ->make($mockedRequestData, $this->rules)
            ->passes();
    }
}
