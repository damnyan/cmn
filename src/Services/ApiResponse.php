<?php

namespace Damnyan\Cmn\Services;

use Illuminate\Http\Response as HttpResponse;

class ApiResponse
{
    protected $response;
    protected $status;
    protected $message;
    protected $errors;

    public function __construct()
    {
        $this->setStatus(HttpResponse::HTTP_OK);
    }

    private function response()
    {
        return response()->json($this->response, $this->status);
    }

    public function append($key, $data)
    {
        $this->response[$key] = $data;
        return $this;
    }

    public static function resourceNotFound($msg = null)
    {
        $response = new static;
        $response->statusNotFound();
        if($msg != null)
            $response->setMessage($msg);

        return $response->response();
    }

    public static function badRequest($msg = null)
    {
        $response = new static;
        $response->statusBadRequest();
        if($msg != null)
            $response->setMessage($msg);

        return $response->response();
    }

    public static function responseOK($msg = null)
    {
        $response = new static;
        if($msg != null)
            $response->setMessage($msg);

        return $response->response();
    }

    public static function responseData($data, $msg = null)
    {
        $response = new static;
        $response->setData($data);
        if($msg != null)
            $response->setMessage($msg);

        return $response->response();
    }

    public static function paginateResponse($data, $msg = null)
    {
        $response = new static;
        $data = $data->toArray();
        foreach($data as $i=>$v)
            $response->append($i, $v);

        if($msg != null)
            $response->setMessage($msg);

        return $response->response();
    }

    public static function forbidden($msg = null)
    {
        $response = new static;
        $response->statusForbidden();
        if($msg != null)
            $response->setMessage($msg);

        return $response->response();
    }

    public static function invalidRequest($msg = null)
    {
        $response = new static;
        $response->statusUnproccessedEntity();
        if($msg != null)
            $response->setMessage($msg);

        return $response->response();
    }

    public static function requestError($errors)
    {
        $response = new static;
        $response->setErrors($errors);
        $response->statusUnproccessedEntity();
        return $response->response();
    }

    private function setData($data)
    {
        $this->response['data'] = $data;
        return $this;
    }

    private function setErrors($errors)
    {
        $this->response['errors'] = $errors;
        return $this;
    }

    private function setMessage($message=null)
    {
        if(!$message) return $this;
        $this->message = $message;
        $this->response['message'] = $message;
        return $this;
    }

    private function setStatus($status)
    {
        $this->status = $status;
        $this->response['status'] = $this->status;
        $this->setDefaultMessage($status);
        return $this;
    }

    private function statusNotFound()
    {
        $this->setStatus(HttpResponse::HTTP_NOT_FOUND);
        return $this;
    }

    private function statusForbidden()
    {
        $this->setStatus(HttpResponse::HTTP_FORBIDDEN);
        return $this;
    }

    private function statusBadRequest()
    {
        $this->setStatus(HttpResponse::HTTP_BAD_REQUEST);
        return $this;
    }

    private function statusUnproccessedEntity()
    {
        $this->setStatus(HttpResponse::HTTP_UNPROCESSABLE_ENTITY);
        return $this;
    }

    private function setDefaultMessage($status)
    {
        $this->setMessage(HttpResponse::$statusTexts[$status]);
    }
}