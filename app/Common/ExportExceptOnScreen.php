<?php

namespace App\Common;

use Illuminate\Http\Request;

trait ExportExceptOnScreen
{
    public function backString(Request $request, $error)
    {
        $request->session()->put('errors', null);
            $errorMes = "";
            foreach ($error->getMessages() as $key => $value) {
                $errorMes .= "<br>".join("", $value);
            }
            return $errorMes;
    }
}
