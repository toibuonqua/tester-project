<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Models\Account;

use App\Mail\RegisterMail;
use App\Mail\ForgetPassMail;
use App\Models\LinkedAccount;
use App\Models\SystemConfiguration;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\Response;

/**
 * AccountController is an abstract class handle logic for Account.
 * Always return as format
 * ```
 *  [
 *   "status_code" => self::ACCOUNT_DEACTIVATED,
 *   "message" => "Account has not been verified yet"
 *  ]
 * ```
 */
abstract class AccountController extends Controller
{
    const LOGIN_FAILED = "LOGIN_FAILED";
    const ACCOUNT_EXPIRED = "ACCOUNT_EXPIRED";
    const ACCOUNT_DEACTIVATED = "ACCOUNT_DEACTIVATED";
    const ACCOUNT_PENDING = "ACCOUNT_PENDING";
    const ADMIN_LOGIN_SUCCESSFUL = "ADMIN_LOGIN_SUCCESSFUL";
    const ASSISTANT_LOGIN_SUCCESSFUL = "ASSISTANT_LOGIN_SUCCESSFUL";
    const USER_LOGIN_SUCCESSFUL = "USER_LOGIN_SUCCESSFUL";
    const LOGIN_ONCE_FAILED = "LOGIN_ONCE_FAILED";

    /**
     * Login base function
     *
     * Check if user's credentials correct. If correct then check if user has already logged in,
     * if true then store user's credentials in session for authenticating user when user choose to proceed to login.
     * When forceLogin, get user's credentials from session and call login without validation step
     * @param $request
     * @param Bool $forceLogin whether to login without validation
     */
    protected function _login(Request $request, $forceLogin = false)
    {
        //TODO: need refactor _login, should not using request, take username and password as params
        if (!$forceLogin) {
            $validator = Validator::make($request->all(), [
                'username' => 'required|string|min:6|max:255',
                'password' => 'required|string|min:8|max:255',
            ]);

            if ($validator->fails()) {
                return $this->failValidateResponse(self::LOGIN_FAILED, $validator);
            }
        }

        $credentials = $request->only('username', 'password');
        if (!$credentials) {
            $credentials = [
                'username' => $request->session()->get('username'),
                'password' => $request->session()->get('password')
            ];
        }

        $token = Auth::attempt($credentials);
        if (!$token) {
            return [
                "status_code" => self::LOGIN_FAILED,
                "message" => __('message.login-failed')
            ];
        }


        if (!$forceLogin && $this->checkAlreadyLoggedIn($request, $credentials, $token)) {
            $request->session()->put('username', $credentials['username']);
            $request->session()->put('password', $credentials['password']);

            return [
                "status_code" => self::LOGIN_ONCE_FAILED,
                "message" => __('message.login-once-failed')
            ];
        }

        $user = Auth::user();

        return $this->verifyAccount($request, $user, $token);
    }

    const EMAIL_CANT_LOGIN = 'EMAIL_CANT_LOGIN';
    const GOOGLE_VERIFY_FAILED = 'GOOGLE_VERIFY_FAILED';

    protected function _loginAsGmail(Request $request)
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return [
                "status_code" => self::GOOGLE_VERIFY_FAILED,
                "message" => __('message.verify-email-failed')
            ];
        }

        $email = $user['email'];

        // Search for email exist in Account table
        $account = Account::where("email", $email)->first();

        if (!$account) {
            return [
                "status_code" => self::EMAIL_CANT_LOGIN,
                "message" => __('message.email-cant-login')
            ];
        }

        $linkedAccount = LinkedAccount::where("account_id", $account->id)->where("social_id", $user['id'])->first();

        if (!$linkedAccount) {
            $linkedAccount = new LinkedAccount([
                "account_id" => $account->id,
                "social_id" => $user['id'],
                "social_name" => $user['name'],
                "social_provider" => "google",
            ]);

            $linkedAccount->save();
        }

        return array_merge($this->verifyAccount($request, $account, ''), ['account' => $account]);
    }


    private function verifyAccount($request, $user, $token)
    {
        if ($user->expired_at && Carbon::parse($user->expired_at) < now()) {
            return [
                "status_code" => self::ACCOUNT_EXPIRED,
                "message" => __('message.account-expired')
            ];
        }

        if ($user->status == Account::STATUS_DEACTIVATED) {
            return [
                "status_code" => self::ACCOUNT_DEACTIVATED,
                "message" => __('message.account-deactivated')
            ];
        }

        if ($user->status == Account::STATUS_PENDING) {
            return [
                "status_code" => self::ACCOUNT_PENDING,
                "message" => __('message.account-not-verified')
            ];
        }

        if ($user->type === Account::TYPE_ADMIN) {
            return [
                "status_code" => self::ADMIN_LOGIN_SUCCESSFUL,
                "message" => __('message.login-success')
            ];
        }

        $this->saveSessionIdAndToken($request, $user, $token);

        if ($user->type === Account::TYPE_CLASS_ASSISTANT) {
            return $this->createNewToken($token, self::ASSISTANT_LOGIN_SUCCESSFUL);
        }

        return $this->createNewToken($token);
    }


    const LOGOUT_SUCCESSFUL = "LOGOUT_SUCCESSFUL";

    /**
     * Log out user base (Invalidate the token).
     *
     */
    protected function _logout()
    {
        Auth::logout();
        return [
            "status_code" => self::LOGOUT_SUCCESSFUL,
            'message' => 'User successfully signed out'
        ];
    }


    const INPUT_INVALID = "INPUT_INVALID";
    const SEND_MAIL_ERROR = "SEND_MAIL_ERROR";
    const SAVE_ERROR = "SAVE_ERROR";
    const REGISTER_SUCCESSFUL = "REGISTER_SUCCESSFUL";

    /**
     * Register account handler
     *
     */
    protected function _register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|min:6|max:255|alpha_num',
            'password' => 'required|string|min:8|max:255',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return $this->failValidateResponse(self::INPUT_INVALID, $validator);
        }

        $account = new Account([
            "username" => $request->input("username"),
            "password" => $request->input("password"),
            "email" => $request->input("email"),
        ]);
        $account->hashPassword();

        $verificationKey = $account->generateAccessToken();

        try {
            $account->save();
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return [
                "status_code" => self::SAVE_ERROR,
                "message" => "Duplicate username or email. Please use another username and email"
            ];
        }

        try {
            $details = [
                "name" => $account->username,
                "verificationKey" => $verificationKey,
                "username" => $account->username
            ];
            Mail::to($account->email)->send(new RegisterMail($details));
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return [
                "status_code" => self::SEND_MAIL_ERROR,
                "message" => "Cannot send email"
            ];
        }


        return [
            "status_code" => self::REGISTER_SUCCESSFUL,
            "message" => "Account has been registered successfully"
        ];
    }

    const EMAIL_NOT_EXIST = "EMAIL_NOT_EXIST";
    const FORGET_PASSWORD_MAIL_SENT = "FORGET_PASSWORD_MAIL_SENT";


    /**
     * Forget password function flow
     */
    protected function _forgetPassword(Request $request)
    {
        $email = $request->input("email");
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        $account = Account::where("email", $email)->first();

        if ($validator->fails()) {
            return $this->failValidateResponse(self::INPUT_INVALID, $validator);
        }
        if ($account == null) {
            return [
                "status_code" => self::EMAIL_NOT_EXIST,
                "message" => "Email does not exist"
            ];
        }

        try {
            $details = [
                "name" => $account->username,
                "verificationKey" => $account->generateAccessToken(),
                "username" => $account->username
            ];
            Mail::to($account->email)->send(new ForgetPassMail($details));
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return [
                "status_code" => self::SEND_MAIL_ERROR,
                "message" => "Cannot send email"
            ];
        }

        // Save access token key. Notice that if the access token changed, the previous token will expired
        $account->save();
        return [
            "status_code" => self::FORGET_PASSWORD_MAIL_SENT,
            "message" => "Mail has been sent successfully"
        ];
    }

    const WRONG_PASSWORD = "WRONG_PASSWORD";
    const CHANGE_PASSWORD_SUCCESSFUL = "CHANGE_PASSWORD_SUCCESSFUL";

    /**
     * Change password request
     */
    protected function _changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'currentPassword' => 'required|string|min:8|max:255',
            'newPassword' => 'required|string|min:8|max:255',
            'newPasswordConfirm' => 'required|string|min:8|max:255|required_with:newPassword|same:newPassword',
        ]);

        if ($validator->fails()) {
            return $this->failValidateResponse(self::INPUT_INVALID, $validator);
        }

        $account = Account::where("username", Auth::user()->username)->first();

        $currentPassword = $request->input("currentPassword");
        $newPassword = $request->input("newPassword");

        if (!$account->checkPassword($currentPassword)) {
            return [
                "status_code" => self::WRONG_PASSWORD,
                "message" => "Old password is not correct"
            ];
        }

        try {

            $account->password = $newPassword;
            $account->hashPassword();
            $account->save();
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return [
                "status_code" => self::SAVE_ERROR,
                "message" => "Cannot change password"
            ];
        }

        return [
            "status_code" => self::CHANGE_PASSWORD_SUCCESSFUL,
            "message" => "Password changed"
        ];
    }


    const KEY_INVALID = "VERIFY_KEY_INVALID";
    const VERIFY_COMPLETED = "VERIFY_COMPLETED";

    /**
     * Verify account handle function
     */
    protected function _verifyRegisterMail(Request $request, $username, $key)
    {

        $account = Account::where("username", $username)->first();

        if ($account == null || !$account->verifyAccessToken($key)) {
            Log::info("Request not found for username: $username, key: $key");
            return [
                "status_code" => self::KEY_INVALID,
                "message" => __('message.invalid-verification-key')
            ];
        }

        $configRRA = SystemConfiguration::getConfigRRA();

        $account->status = ($account->created_by_admin || !$configRRA) ? Account::STATUS_ACTIVATED : Account::STATUS_PENDING;
        $account->email_verified_at = now();

        try {
            $account->save();
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return [
                "status_code" => self::SAVE_ERROR,
                "message" => __('message.update-fail')
            ];
        }

        return [
            "status_code" => self::VERIFY_COMPLETED,
            "message" => __('message.verify-success')
        ];
    }

    /**
     * Base controller for handling action when user click on the link in forget password mail
     *
     * @param $request original request
     * @param $username
     * @param $key
     */
    protected function _validateForgetPassword(Request $request, $username, $key)
    {
        $account = Account::where("username", $username)->first();

        if ($account == null || !$account->verifyAccessToken($key)) {
            return [
                "status_code" => self::KEY_INVALID,
                "message" => "URL is not correct."
            ];
        }

        $account->email_verified_at = now();
        try {
            $account->save();
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return [
                "status_code" => self::SAVE_ERROR,
                "message" => "Cannot update this account's status"
            ];
        }


        return [
            "status_code" => self::VERIFY_COMPLETED,
            "message" => "This email has been verified",
            "page_data" => ["username" => $username, "key" => $key]
        ];
    }


    /**
     * Base controller for handling action when user submit new password
     *
     * @param Request $request require 'password' as body request
     * @param string $username a router parameter for fast check account
     * @return string[]
     */
    protected function _setNewPassword(Request $request, $username)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|max:255',
        ]);

        $newPassword = $request->input('password');
        $newPasswordConfirm = $request->input('password');

        if ($validator->fails() || $newPassword != $newPasswordConfirm) {
            return [
                "status_code" => self::INPUT_INVALID,
                "message" => "Password is not valid"
            ];
        }

        $account = Account::where("username", $username)->first();
        $key = $request->input('key');

        if ($account == null) {
            return [
                "status_code" => self::INPUT_INVALID,
                "message" => "Account not exist"
            ];
        }

        if (!$account->verifyAccessToken($key)) {
            return ["status_code" => self::KEY_INVALID, "message" => "The key is not correct"];
        }

        $account->password = $newPassword;
        $account->hashPassword();

        try {
            $account->save();
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return [
                "status_code" => self::SAVE_ERROR,
                "message" => "Cannot update this account's status"
            ];
        }

        return [
            "status_code" => self::VERIFY_COMPLETED,
            "message" => "New password has been updated."
        ];
    }


    ### HELPER CONTROLLER


    /**
     * Get the token array structure.
     *
     * @param string $token
     */
    private function createNewToken($token, $statusCode = self::USER_LOGIN_SUCCESSFUL)
    {
        return [
            "token" => $token,
            "status_code" => $statusCode,
            "message" => __('message.login-success'),
        ];
    }

    /**
     * Save session id and jwt token of logged in user to database
     *
     * @param Request $request
     * @param Account $user current logged in user
     * @param String $token jwt token generated for current user
     * @return void
     */
    private function saveSessionIdAndToken($request, $user, $token)
    {
        $request->session()->put('token', $token);
        $sessionId = $request->session()->getId();

        $expiredAt = Carbon::now()->addHour(Account::USER_JWT_TOKEN_TTL_IN_HOUR);
        if ($user->type === Account::TYPE_CLASS_ASSISTANT) {
            $expiredAt = Carbon::now()->addDay(Account::ASSISTANT_JWT_TOKEN_TTL_IN_DAY);
        }

        $user->setJwtToken($token, $expiredAt);
        $user->setSessionId($sessionId);
        return $user->save(['timestamps' => false]);
    }

    /**
     * Check if a user has already logged in with given credentials and jwt token
     *
     *  A user is already logged in if:
     *  - User has an active session stored in database
     *  - The active session has different session id and jwt token from request's session
     *
     * @param Request $request
     * @param array $credentials array containing user's credentials (username and password)
     * @param String $token jwt token generated for the credentials after matching user's credentials
     * @return Bool
     */
    private function checkAlreadyLoggedIn($request, $credentials, $token)
    {
        $sessionId = $request->session()->getId();
        $user = Account::user()->where('username', $credentials['username'])->first();
        return ($user && $user->hasActiveSession() && !$user->hasCurrentActiveSession($sessionId, $token));
    }
}
