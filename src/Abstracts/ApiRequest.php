<?php

namespace Damnyan\Cmn\Abstracts;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Damnyan\Cmn\Exceptions\UnprocessedEntityException;

abstract class ApiRequest extends FormRequest
{

    /**
     * Default for authorize
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * For json error response
     *
     * @param \Illuminate\Validation\Validator $validator validator
     * @throws UnprocessedEntityException
     * @return void
     */
    public function failedValidation(Validator $validator)
    {
        throw new UnprocessedEntityException($validator->errors());
    }
}
