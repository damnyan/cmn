<?php

namespace Damnyan\Cmn\Services;

use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Request;

class ApiResponse
{
    protected $responseData;
    protected $status;
    protected $message;
    protected $errors;
    protected $headers = [];

    public function __construct()
    {
        $this->setStatus(HttpResponse::HTTP_OK);
    }

    private function response()
    {
        return response()
            ->json($this->responseData, $this->status)
            ->withHeaders($this->headers);
    }

    public static function resource($resource)
    {
        $apiResponse = new static;
        $apiResponse->setResponse($resource);
        return $apiResponse->responseData;
    }

    public static function created($msg = null, $id = null)
    {
        $url = Request::path().'/'.$id;
        $apiResponse = new static;
        $apiResponse->statusCreated();

        if ($id) {
            $apiResponse->addHeader('Location', $url);
        }

        if ($msg != null) {
            $apiResponse->setMessage($msg);
        }

        return $apiResponse->response();
    }

    public static function resourceNotFound($msg = null)
    {
        $apiResponse = new static;
        $apiResponse->statusNotFound();

        if ($msg != null) {
            $apiResponse->setMessage($msg);
        }

        return $apiResponse->response();
    }

    public static function badRequest($msg = null)
    {
        $apiResponse = new static;
        $apiResponse->statusBadRequest();

        if ($msg != null) {
            $apiResponse->setMessage($msg);
        }

        return $apiResponse->response();
    }

    public static function responseOK($msg = null)
    {
        $apiResponse = new static;
        
        if ($msg != null) {
            $apiResponse->setMessage($msg);
        }

        return $apiResponse->response();
    }

    public static function responseData($data, $msg = null)
    {
        $apiResponse = new static;
        $apiResponse->setResponse($data);
        
        if ($msg != null) {
            $apiResponse->setMessage($msg);
        }

        return $apiResponse->response();
    }

    public static function forbidden($msg = null)
    {
        $apiResponse = new static;
        $apiResponse->statusForbidden();
        
        if ($msg != null) {
            $apiResponse->setMessage($msg);
        }

        return $apiResponse->response();
    }

    public static function unproccessedEntity($errors)
    {
        $apiResponse = new static;
        $apiResponse->setErrors($errors);
        $apiResponse->statusUnproccessedEntity();
        return $apiResponse->response();
    }

    public static function internalServerError($code, $msg = null)
    {
        $apiResponse = new static;
        $apiResponse->statusInternalServerError();
        
        $apiResponse->setResponse(['code' => $code]);

        if ($msg != null) {
            $apiResponse->setMessage($msg);
        } else {
            $apiResponse->setDefaultMessage($apiResponse->status);
        }

        return $apiResponse->response();
    }

    private function setResponse($data)
    {
        $this->responseData = $data;
        return $this;
    }

    private function setErrors($errors)
    {
        $this->responseData['errors'] = $errors;
        return $this;
    }

    private function setMessage($message = null)
    {
        if (!$message) {
            return $this;
        }
        $this->message = $message;
        $this->responseData['message'] = $message;
        return $this;
    }

    private function setStatus($status)
    {
        $this->status = $status;
        $this->setDefaultMessage($status);
        return $this;
    }

    private function setHeaders($headers)
    {
        $this->headers = $headers;
        return $this;
    }

    private function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
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

    private function statusCreated()
    {
        $this->setStatus(HttpResponse::HTTP_CREATED);
        return $this;
    }

    private function statusInternalServerError()
    {
        $this->setStatus(HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        return $this;
    }

    private function setDefaultMessage($status)
    {
        $this->setMessage(HttpResponse::$statusTexts[$status]);
    }
}
