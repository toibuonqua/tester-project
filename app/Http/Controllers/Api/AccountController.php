<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Base\AccountController as BaseAccountController;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AccountController extends BaseAccountController
{
    use ApiResponseTrait;
    /**
     * Handle login requeset for mobile
     */
    public function login(Request $request)
    {
        $result = $this->_login($request);

        switch ($result["status_code"]) {
            case self::USER_LOGIN_SUCCESSFUL:
                $response = $this->overwriteBaseResponse($result, [
                    "status" => Response::HTTP_OK,
                    "data" => [
                        'access_token' => $result["token"],
                        'token_type' => 'bearer',
                        'expires_in' => Auth::factory()->getTTL() * 60,
                        'user' => Auth::user(),
                    ]
                ]);
                break;

            case self::ADMIN_LOGIN_SUCCESSFUL:
            case self::ASSISTANT_LOGIN_SUCCESSFUL:
                $response = [
                    'status' => Response::HTTP_UNAUTHORIZED,
                    'message' => 'This type of account cannot login to application'
                ];
                break;

            case self::LOGIN_FAILED:
            case self::ACCOUNT_DEACTIVATED:
            default:
                $response = $this->overwriteBaseResponse($result, [
                    "status" => Response::HTTP_UNAUTHORIZED
                ]);
        }

        return response()->json($response, $response["status"]);
    }

    /**
     * Handle logout requeset for mobile
     */
    public function logout(Request $request)
    {
        $result = $this->_logout();

        switch ($result["status_code"]) {
            case self::LOGOUT_SUCCESSFUL:
                $response = $this->overwriteBaseResponse($result, [
                    "status" => Response::HTTP_OK,
                ]);
                break;
            default:
                Log::error("Case unhandled");
        }

        return response()->json($response, $response["status"]);
    }


    const REFRESH_TOKEN_SUCCESSFUL = "REFRESH_TOKEN_SUCCESSFUL";

    /**
     * Refresh token for API
     */
    public function refresh()
    {
        return response()->json([
            "status" => Response::HTTP_OK,
            "status_code" => self::REFRESH_TOKEN_SUCCESSFUL,
            "message" => "success",
            "data" => [
                'access_token' => Auth::refresh(),
                'token_type' => 'bearer',
                'expires_in' => Auth::factory()->getTTL() * 60,
                'user' => Auth::user(),
            ]
        ]);
    }

    /**
     * Get the authenticated User.
     * NOTE: This work as a test API
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return response()->json([
            "status" => Response::HTTP_OK,
            "status_code" => "OK",
            'message' => 'Get user profile sucessfully',
            "data" => Auth::user()
        ]);
    }


    const REGISTER_FAILED = "REGISTER_FAILED";

    /**
     * Register account handler
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $result = $this->_register($request);

        switch ($result["status_code"]) {

            case self::INPUT_INVALID:
            case self::SAVE_ERROR:
                $response = $this->overwriteBaseResponse($result, [
                    "status" => Response::HTTP_BAD_REQUEST,
                    "status_code" => self::REGISTER_FAILED,
                ]);
                break;

            case self::SEND_MAIL_ERROR:
                $response = $this->overwriteBaseResponse($result, [
                    "status" => Response::HTTP_INTERNAL_SERVER_ERROR,
                    "status_code" => self::REGISTER_FAILED,
                ]);
                break;

            case self::REGISTER_SUCCESSFUL:
                $response = $this->overwriteBaseResponse($result, [
                    "status" => Response::HTTP_OK,
                ]);
                break;

            default:
                Log::error("Case unhandled");
        }

        return response()->json($response, $response["status"]);
    }


    const FORGET_PASSWORD_FAILED = "FORGET_PASSWORD_FAILED";

    /**
     * Forget function flow
     *
     */
    public function forgetPassword(Request $request)
    {
        $result = $this->_forgetPassword($request);

        switch ($result["status_code"]) {

            case self::INPUT_INVALID:
            case self::EMAIL_NOT_EXIST:
                $response = $this->overwriteBaseResponse($result, [
                    "status" => Response::HTTP_BAD_REQUEST,
                    "status_code" => self::FORGET_PASSWORD_FAILED,
                ]);
                break;

            case self::SEND_MAIL_ERROR:
                $response = $this->overwriteBaseResponse($result, [
                    "status" => Response::HTTP_INTERNAL_SERVER_ERROR,
                    "status_code" => self::FORGET_PASSWORD_FAILED,
                ]);
                break;

            case self::FORGET_PASSWORD_MAIL_SENT:
                $response = $this->overwriteBaseResponse($result, [
                    "status" => Response::HTTP_OK,
                    "status_code" => self::FORGET_PASSWORD_MAIL_SENT,
                ]);
                break;
        }

        return response()->json($response, $response["status"]);
    }


    const CHANGE_PASSWORD_FAILED = "CHANGE_PASSWORD_FAILED";
    /**
     *
     */
    public function changePassword(Request $request)
    {
        $result = $this->_changePassword($request);

        switch ($result["status_code"]) {

            case self::INPUT_INVALID:
            case self::WRONG_PASSWORD:
                $response = $this->overwriteBaseResponse($result, [
                    "status" => Response::HTTP_BAD_REQUEST,
                    "status_code" => self::CHANGE_PASSWORD_FAILED
                ]);
                break;

            case self::SAVE_ERROR:
                $response = $this->overwriteBaseResponse($result, [
                    "status" => Response::HTTP_INTERNAL_SERVER_ERROR,
                    "status_code" => self::CHANGE_PASSWORD_FAILED
                ]);
                break;

            case self::CHANGE_PASSWORD_SUCCESSFUL:
                $response = $this->overwriteBaseResponse($result, [
                    "status" => Response::HTTP_OK,
                ]);
                break;

            default:
                Log::error("Case unhandled");
        }

        return response()->json($response, $response["status"]);
    }
}
