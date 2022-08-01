<?php

namespace App\Http\Controllers\Api;


/**
 * This is the base Controller of all ApiController.
 * Share logic controller can be written here.
 */
trait ApiResponseTrait
{
    /**
     * Helper function for using Base Controller (which only contain status_code)
     * 
     * @param array $response is the result from any base controller
     * @param array $overwriteObject is the overwrite array of response
     * 
     */
    private function overwriteBaseResponse($response, $overwriteObject)
    {
        foreach ($overwriteObject as $key => $value) {
            $response[$key] = $value;
        }

        return $response;
    }
}
