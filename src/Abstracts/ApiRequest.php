<?php

namespace Damnyan\Cmn\Abstracts;

use Illuminate\Foundation\Http\FormRequest;

abstract class ApiRequest extends FormRequest
{
	public function response(array $errors)
	{
		$response['status'] = 422;
		$response['errors'] = $errors;
		return \Response::json($response ,422);
	}
}
