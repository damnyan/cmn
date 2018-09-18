<?php

use Damnyan\Cmn\Services\ApiResponse;

if (!function_exists('api_response')) {

    /**
     * ApiResponse Helper
     *
     * @return \Damnyan\Cmn\Services\ApiResponse
     */
    function api_response()
    {
        return new ApiResponse;
    }
}
