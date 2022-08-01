<?php

namespace App\Exceptions;

use Exception;

class NotNullValueException extends Exception
{
    public function render() {
        return response()->view("errors.notNullValue");
    }
}
