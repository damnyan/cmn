<?php

namespace Damnyan\Cmn\Abstracts;

use Damnyan\Cmn\Exceptions\UnprocessedEntityException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class ApiRequest extends FormRequest
{
    public function failedValidation(Validator $validator)
    {
        throw new UnprocessedEntityException($validator->errors());
    }
}
