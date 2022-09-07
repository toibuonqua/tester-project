<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * This is the base Controller of all WebController.
 * Share logic controller can be written here.
 */
trait WebResponseTrait
{
    /**
     * Extract message from session (only 1 time). After extract, message in the
     * session should be deleted unless sset otherwise
     *
     * @param Request $request
     * @param Boolean $oneTime True for delete the message/messageType after get
     * @return [message, messageType]
     */
    public function extractMessage(Request $request, $oneTime = True)
    {
        Log::alert("extractMessage for message and messageType has been depricated");
        $message = null;
        $messageType = null;

        if ($request->session()->get('message')) {
            $message = $request->session()->get('message');
            $messageType = $request->session()->get('messageType');
        }

        if ($oneTime) {
            $request->session()->forget(['message', 'messageType']);
        }

        return ['message' => $message, 'messageType' => $messageType];
    }

    public function updateMessage(Request $request, $message, $messageType)
    {
        $request->session()->put('message', $message);
        $request->session()->put('messageType', $messageType);
    }

    public function updateFailMessage(Request $request, $message)
    {
        $this->updateMessage($request, $message, 'danger');
    }

    public function updateSuccessMessage(Request $request, $message)
    {
        $this->updateMessage($request, $message, 'success');
    }

    // public function backString(Request $request, $error)
    // {
    //     $request->session()->put('errors', null);
    //         $errorMes = "";
    //         foreach ($error->getMessages() as $key => $value) {
    //             $errorMes .= "<br>".join("", $value);
    //         }
    //         return $errorMes;
    // }


    /**
     * Generate Validate message array map for validator
     * Using as **$mesesage** of
     *
     * ```
     * Validator::make($request->all(), $rules, $message, $customAttribute)
     * ```
     *
     * Ex:
     * ```
     * genValidateMessage(['abc', 'def'])
     * =>
     * ['abc' => __('validate.abc'), 'def' => __('validate.abc')]
     * ```
     *
     * @param array $messageKeyList See the list of possible keys in `lang/xx/validate.php`
     * @return array
     */
    public function genValidateMessage(array $messageKeyList)
    {
        $validateList = [];
        foreach ($messageKeyList as $messageKey) {
            $validateList[$messageKey] = __("validate.$messageKey");
        }
        return $validateList;
    }

    /**
     * Generate Attribubte array map for Validator.
     * Using as **$customAttribute** of
     *
     * ```
     * Validator::make($request->all(), $rules, $message, $customAttribute)
     * ```
     *
     * Ex:
     * ```
     * genAttributeKey(['abc', 'def'])
     * =>
     * ['abc' => __('title.abc'), 'def' => __('title.abc')]
     * ```
     *
     * See the list of possible keys in `lang/xx/title.php`
     *
     * @param array $attributeKeyList
     * @return array
     */
    public function genAttributeKey(array $attributeKeyList)
    {
        $attributeList = [];
        foreach ($attributeKeyList as $messageKey) {
            $attributeList[$messageKey] = __("title.$messageKey");
        }
        return $attributeList;
    }
}
