<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** A helper to return response if validation failed
     *
     */
    protected function failValidateResponse(string $statusCode, $validator)
    {
        $errorMessage = "";
        foreach ($validator->errors()->all() as $message) {
            $errorMessage .= " " . __($message);
        }

        return [
            "status_code" => $statusCode,
            "message" => $errorMessage
        ];
    }
}
