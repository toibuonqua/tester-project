<?php

namespace App\Exceptions;

use Exception;

class NotDuplicateValueException extends Exception
{
    public function render() {
        return response()->view("errors.notDuplicateValue");
    }
}
