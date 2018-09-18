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

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setStatus(HttpResponse::HTTP_OK);
    }

    /**
     * Response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function response()
    {
        return response()
            ->json($this->responseData, $this->status)
            ->withHeaders($this->headers);
    }

    /**
     * Set response data
     *
     * @param mixed $data data
     * @return $this
     */
    private function setResponse($data)
    {
        $this->responseData = $data;
        return $this;
    }

    /**
     * Resouce
     *
     * @param mixed $resource resource
     * @return void
     */
    public function resource($resource)
    {
        $this->setResponse($resource);

        return $this->responseData;
    }

    /**
     * Resource created
     *
     * @param mixed $resource resource
     * @return void
     */
    public function resourceCreated($resource)
    {
        $this->setStatus(HttpResponse::HTTP_CREATED);

        return $this->resource(
            $resource->additional(
                [
                    'message' => $resource->getResourceName().' successfully created.'
                ]
            )
        );
    }

    /**
     * Resource updated
     *
     * @param mixed $resource resource
     * @return void
     */
    public function resourceUpdated($resource)
    {
        return self::resource(
            $resource->additional(
                [
                    'message' => $resource->getResourceName().' successfully updated.'
                ]
            )
        );
    }

    /**
     * Resource deleted
     *
     * @param mixed $resource resource
     * @return void
     */
    public function resourceDeleted($resource)
    {
        return self::responseOK(
            $resource->getResourceName().' successfully deleted.'
        );
    }

    /**
     * Resource not found
     *
     * @param string $message message
     * @return \Illuminate\Http\JsonResponse
     */
    public function resourceNotFound($message = null)
    {
        $this->setStatus(HttpResponse::HTTP_NOT_FOUND);
        $this->setMessage($message);

        return $this->response();
    }

    /**
     * Bad request
     *
     * @param string $message message
     * @return \Illuminate\Http\JsonResponse
     */
    public function badRequest($message = null)
    {
        $this->setStatus(HttpResponse::HTTP_BAD_REQUEST);
        $this->setMessage($message);

        return $this->response();
    }

    /**
     * Response OK
     *
     * @param string $message message
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseOk($message = null)
    {
        $this->setMessage($message);

        return $this->response();
    }

    /**
     * Forbidden
     *
     * @param string $message message
     * @return \Illuminate\Http\JsonResponse
     */
    public function forbidden($message = null)
    {
        $this->setStatus(HttpResponse::HTTP_FORBIDDEN);
        $this->setMessage($message);

        return $this->response();
    }

    /**
     * Unprocessed entity response
     *
     * @param array $errors errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function unproccessedEntity($errors)
    {
        $this->setStatus(HttpResponse::HTTP_UNPROCESSABLE_ENTITY);
        $this->responseData['errors'] = $errors;
        return $this->response();
    }

    /**
     * Internal server error
     *
     * @param integer $errorCode not response status code
     * @param string  $message    message
     * @return void
     */
    public function internalServerError($errorCode, $message = null)
    {
        $this->setStatus(HttpResponse::HTTP_INTERNAL_SERVER_ERROR);

        $this->setResponse(['code' => $errorCode]);
        $this->setMessage($message);

        return $this->response();
    }

    /**
     * Set response message
     *
     * @param string $message message
     * @return void
     */
    private function setMessage($message = null)
    {
        if (!$message) {
            return $this->setDefaultMessage($this->status);
        }

        $this->message = $message;
        $this->responseData['message'] = $message;
        return $this;
    }

    /**
     * Set response satus code
     *
     * @param [type] $status
     * @return void
     */
    private function setStatus($status)
    {
        $this->status = $status;
        $this->setDefaultMessage($status);
        return $this;
    }

    /**
     * Set default message
     *
     * @param integer $status status code
     * @return void
     */
    private function setDefaultMessage($status)
    {
        $this->setMessage(HttpResponse::$statusTexts[$status]);
    }
}
