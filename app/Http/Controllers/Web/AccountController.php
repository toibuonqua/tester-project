<?php

namespace App\Http\Controllers\Web;

use App\Common\TransformList;
use App\Http\Controllers\Base\AccountController as BaseAccountController;
use App\Models\Account;
use App\Models\Classroom;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class AccountController extends BaseAccountController
{
    use WebResponseTrait, PaginationTrait;


    const CREATE_ASSISTANT_ACCOUNT = 'assistant';
    const CREATE_STUDENT_ACCOUNT = 'student';

    public function home(Request $request)
    {
        $message = $request->input('message');
        $messageCode = $request->input('messageCode');
        return view('login', [
            'message' => $message ?? __($messageCode),
        ]);
    }

    /**
     * Handle when user click login
     *
     * @param Request $request
     *
     */
    public function login(Request $request, $forceLogin = false)
    {
        App::setLocale("vi");

        $result = $this->_login($request, $forceLogin);

        switch ($result["status_code"]) {
            case self::ADMIN_LOGIN_SUCCESSFUL:
                $request->session()->put(Account::TYPE_ADMIN, Auth::user());
                return redirect(route('admin-dashboard'));

            case self::ASSISTANT_LOGIN_SUCCESSFUL:
                $request->session()->put(Account::TYPE_CLASS_ASSISTANT, Auth::user());
                return redirect(route('assistant.students'));

            case self::USER_LOGIN_SUCCESSFUL:
                $request->session()->put(Account::TYPE_USER, Auth::user());
                return redirect(route('user.dashboard'));

            case self::LOGIN_ONCE_FAILED:
                return response()->view('user.login-once', [
                    "message" => $result['message'],
                    "messageType" => "danger",
                    "username" => $request->get('username')
                ]);
            default:
                $request->flash();
                $this->updateFailMessage($request, $result['message']);
                return redirect()->route('home');
        }
    }

    /**
     * Handle when user click logout
     */
    public function logout(Request $request)
    {
        $user = $request->session()->get(Account::TYPE_USER);

        if ($user) {
            $user->setJwtToken(null);
            $user->setSessionId(null);
            $user->save();
        }


        $request->session()->put('token', null);
        $request->session()->put(Account::TYPE_ADMIN, null);
        $request->session()->put(Account::TYPE_CLASS_ASSISTANT, null);
        $request->session()->put(Account::TYPE_USER, null);
        return redirect(route('home'));
    }

    /**
     * Process user login options when user already logged in on another device/browser with current credentials
     *
     * @param Request $request
     */
    public function processLoginOptions(Request $request)
    {
        switch ($request->input('action')) {
            case 'proceed-login':
                return $this->login($request, true);

            case 'logout':
            default:
                return $this->logout($request);
        }
    }

    /**
     * Handle action when user clicks on the link in register email
     *
     * @param Request $request
     * @param $username
     * @param $key
     */
    public function verifyRegisterMail(Request $request, $username, $key)
    {
        $result = $this->_verifyRegisterMail($request, $username, $key);

        // There're no separate flow for these cases yet.

        // switch ($result["status_code"]) {
        //     case self::KEY_INVALID:
        //     case self::SAVE_ERROR:
        //     case self::VERIFY_COMPLETED:
        // }

        return response()->view('common.singleMessage', $result);
    }

    /**
     * Handle action when user clicks on the link in forget password email
     *
     * @param Request $request
     * @param $username
     * @param $key
     */
    public function validateForgetPassword(Request $request, $username, $key)
    {
        $result = $this->_validateForgetPassword($request, $username, $key);

        switch ($result["status_code"]) {
            case self::VERIFY_COMPLETED:
                return response()->view('common.resetPassword', $result["page_data"]);

                // case self::KEY_INVALID:
                // case self::SAVE_ERROR:
        }

        return response()->view('common.singleMessage', $result);
    }

    /**
     * Check and update new password for account verified
     *
     * @param Request $request
     * @param $username string is used for detect user quickly
     * @return \Illuminate\Http\Response
     */
    public function setNewPassword(Request $request, $username)
    {
        $result = $this->_setNewPassword($request, $username);

        $key = $request->input('key');
        switch ($result["status_code"]) {
                // case self::KEY_INVALID:
                // case self::SAVE_ERROR:
                // case self::VERIFY_COMPLETED:
            case self::INPUT_INVALID:
                return response()->view('account.resetPassword', [
                    "username" => $username,
                    "message" => "The password does not meet requirement. Please input again.",
                    "key" => $key
                ]);
        }

        return response()->view('common.singleMessage', $result);
    }


    public function editPassword(Request $request)
    {
        $type = Account::TYPE_USER;

        $assistant = $request->session()->get(Account::TYPE_CLASS_ASSISTANT);
        if ($assistant) {
            $type = Account::TYPE_CLASS_ASSISTANT;
        }

        return view('account.change-password', compact('type'));
    }

    public function updatePassword(Request $request)
    {
        $validator = $this->makeValidator($request->all());
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $user = $request->session()->get(Account::TYPE_USER);
        if ($user) {
            $account = $user;
        } else {
            $account = $request->session()->get(Account::TYPE_CLASS_ASSISTANT);
        }


        $oldPassword = $request->input('old-password');
        $newPassword = $request->input('new-password');

        if (!$account->checkPassword($oldPassword)) {
            $this->updateFailMessage($request, __('message.password-not-match'));
            return redirect()->back();
        }

        try {
            $account->updatePassword($newPassword);
            $message = __('message.update-successful');
            $messageType = 'success';
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $message = __('message.update-fail');
            $messageType = 'danger';
        }

        $this->updateMessage($request, $message, $messageType);
        return redirect()->back();
    }

    private function makeValidator($data)
    {
        $rules = [
            'old-password' => 'required',
            'new-password' => 'required|min:8',
            'confirm-password' => 'required|same:new-password',
        ];

        $messages = [
            'old-password.required' => __('validate.required', ['attribute' => __('title.old-password')]),
            'new-password.required' => __('validate.required', ['attribute' => __('title.new-password')]),
            'new-password.min' => __('validate.min-length', [
                'attribute' => __('title.new-password'),
                'length' => 8
            ]),
            'confirm-password.required' => __('validate.required', ['attribute' => __('title.confirm-password')]),
            'confirm-password.same' => __('validate.password-confirmation'),
        ];

        return Validator::make($data, $rules, $messages);
    }

    public function loginAsGmail(Request $request)
    {
        $result = $this->_loginAsGmail($request);

        switch ($result["status_code"]) {
            case self::ADMIN_LOGIN_SUCCESSFUL:
                $request->session()->put(Account::TYPE_ADMIN, $result['account']);
                $this->updateSuccessMessage($request, $result['message']);
                return redirect(route('admin-dashboard'));

            case self::ASSISTANT_LOGIN_SUCCESSFUL:
                $request->session()->put(Account::TYPE_CLASS_ASSISTANT, $result['account']);
                $this->updateSuccessMessage($request, $result['message']);
                return redirect(route('assistant.exam-list'));

            case self::USER_LOGIN_SUCCESSFUL:
                $request->session()->put(Account::TYPE_USER, $result['account']);
                $this->updateSuccessMessage($request, $result['message']);
                return redirect(route('user.dashboard'));

            default:
                $this->updateFailMessage($request, $result['message']);
                return redirect()->route('home');
        }
    }

    const DEFAULT_STATUS_SELECT = [
        Account::STATUS_ACTIVATED,
        Account::STATUS_DEACTIVATED,
        Account::STATUS_PENDING
    ];

    const DEFAULT_LIMIT = 20;

    public function searchAccounts(Request $request, $searchParams)
    {
        $accountListQuery  = Account::with('courses')
            ->with('accessClasses')
            ->withFilter($searchParams);

        $this->updateNumberPerPageSession($request, self::DEFAULT_LIMIT);

        $paginationParams = $this->getPaginationParam($request, $accountListQuery->count());
        [
            'offset' => $offset,
            'limit' => $limit,
        ] = $paginationParams;

        $accounts = $accountListQuery
            ->orderBy('created_at', 'desc')
            ->skip($offset)
            ->take($limit)
            ->get();

        return [
            'accounts' => $accounts,
            'paginationParams' => $paginationParams
        ];
    }

    protected function extractSearchParams(Request $request): array
    {
        if ($request->method() == 'POST') {
            return $request->except('_token');
        }

        return [
            'type' => $request->input('type', Account::TYPE_USER),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'status' => $request->input('status', self::DEFAULT_STATUS_SELECT),
            'from' => $request->input('from', now()->subMonths(6)->toDateString()),
            'to' => $request->input('to', now()->toDateString()),
            'class_id' => $request->input('class')
        ];
    }

    const UPDATE_STATUS_SUCCESS = 'UPDATE_STATUS_SUCCESS';
    const UPDATE_STATUS_FAILED = 'UPDATE_STATUS_FAILED';
    protected function updateAccountStatus(Request $request): array
    {
        $accountStatus = $request->input('user-status');
        try {
            Account::updateStatus($accountStatus);
            return [
                'status_code' => self::UPDATE_STATUS_SUCCESS,
                'message' =>  __('message.update-successful')
            ];
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return [
                'status_code' => self::UPDATE_STATUS_FAILED,
                'message' =>  __('message.update-fail')
            ];
        }
    }

    protected function makeAccountValidator($data, $accountType = self::CREATE_ASSISTANT_ACCOUNT)
    {
        if ($accountType == self::CREATE_ASSISTANT_ACCOUNT) {
            $rules = [
                'username' => 'required|unique:account',
                'email' => 'required|email|unique:account',
                'password' => 'required|min:8',
                'confirm-password' => 'same:password',
            ];
        } else {
            $rules = [
                'usernames.*.username' => 'min:6|max:255',
            ];
        }

        $validator = Validator::make($data, $rules);

        if ($accountType == self::CREATE_STUDENT_ACCOUNT) {
            $validator->sometimes('password', 'min:8', function ($input) {
                return $input->password != null;
            });
        }
        return $validator;
    }

    /**
     * Transform string containing usernames into a list of usernames with some preprocessing
     *
     * @param string $usernames list of usernames separated by comma or new line character
     * @return TransformList $transformedUsernames tranformed list of usernames wrapped inside an object
     */
    protected function preprocessUsernames($usernames)
    {
        $usernameList = preg_split('/,|\r\n|\r|\n/', $usernames);

        $transformedUsernames = new TransformList($usernameList);
        $transformedUsernames = $transformedUsernames->transformList([
            'trim'
        ])->filterList([
            fn ($username) => strlen($username) > 0
        ])->transformList([
            fn ($username) => ['username' => $username]
        ]);
        return $transformedUsernames;
    }

    /**
     * Validation for multiple usernames input
     *
     * @param Request $request
     * @return array contains information include: valid/invalid usernames, error messages, failed attributes
     * @throws Exception if request does not contain usernames input field
     */
    protected function validateStudentInput(Request $request)
    {
        if (!$request->input('usernames')) {
            throw new Exception(__('validate.required', ['attribute' => __('title.username')]));
        }

        $password = $request->input('password');
        $usernames = $request->input('usernames');

        $transformedUsernames = $this->preprocessUsernames($usernames);

        $validator = $this->makeAccountValidator([
            'usernames' => $transformedUsernames->getList(),
            'password' => $password,
        ], self::CREATE_STUDENT_ACCOUNT);

        $transformedUsernames = $transformedUsernames->transformList([
            fn ($username) => $username['username']
        ]);

        [$invalidUsernames, $validUsernames] = $this->filterUsernamesFromValidator($validator, $transformedUsernames->getList());

        $errors = $validator->errors()->getMessages();
        $failedAttributes = $validator->failed();

        return [$invalidUsernames, $validUsernames, $errors, $failedAttributes];
    }

    /**
     * Filter valid and invalid usernames after validation
     *
     * @param ValidationValidator $validator
     * @param array $usernames contains list of usernames to be filtered
     * @return array contains list of invalid and valid users
     */
    private function filterUsernamesFromValidator($validator, $usernames)
    {
        $invalidUsernameIdxes = [];
        $invalidUsernames = [];
        $validUsernames = [];

        if ($validator->fails()) {
            $usernameErrors = $validator->errors()->get('usernames.*');
            foreach ($usernameErrors as $key => $err) {
                $invalidUsernameIdxes[] = explode('.', $key)[1];
            }
        }

        foreach ($usernames as $key => $username) {
            if (in_array($key, $invalidUsernameIdxes)) {
                $invalidUsernames[$key] = $username;
            } else {
                $validUsernames[] = $username;
            }
        }

        return [$invalidUsernames, $validUsernames];
    }

    /**
     * Generate error message after validation
     *
     * @param array $errors contains pairs of field and list of its validation error messages
     * @param array $failedAttributes contains pair of field and list of its validation rules failed
     * @param array $invalidUsernames contains list of invalid usernames
     * @return string
     */
    private function genErrorMessage($errors, $failedAttributes, $invalidUsernames)
    {
        $usernameErrors = [];
        $errorMsg = '';

        // get username errors
        foreach ($failedAttributes as $key => $attrList) {
            $userIndex = explode('.', $key)[1];
            if (str_contains($key, 'usernames')) {
                foreach ($attrList as $rule => $value) {
                    $usernameErrors[strtolower($rule)][] = $invalidUsernames[$userIndex];
                }
            }
        }

        //format usernames error messages
        foreach ($usernameErrors as $type => $usernames) {
            $errorMsg .= __("validate.$type", [
                'attribute' => __('title.account'),
                'value' => implode(', ', $usernames),
            ]) . '<br/>';
        }

        //add other types of error messages
        foreach ($errors as $key => $msgList) {
            if (!str_contains($key, 'usernames')) {
                foreach ($msgList as $msg) {
                    $errorMsg .= $msg . '<br/>';
                }
            }
        }
        return $errorMsg;
    }

    const CREATE_STUDENTS_FAILED = 'CREATE_STUDENTS_FAILED';
    const CREATE_STUDENTS_SUCCESS = 'CREATE_STUDENTS_SUCCESS';
    protected function _createStudents(Request $request)
    {
        try {
            [$invalidUsernames, $validUsernames, $errors, $failedAttributes] = $this->validateStudentInput($request);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return [
                'status_code' => self::CREATE_STUDENTS_FAILED,
                'message' => $e->getMessage()
            ];
        }

        $password = $request->input('password', null);
        $expiredAt = $request->input('expired-at', Carbon::now()->addMonths(Account::EXPIRED_IN_MONTH));
        $classId = $request->input('class');

        $defaultValues = [
            'password' => $password,
            'class_id' => $classId,
            'expired_at' => $expiredAt
        ];

        $class = Classroom::find($defaultValues['class_id']);
        if (!$class) {
            return [
                'status_code' => self::CREATE_STUDENTS_FAILED,
                'message' => __('message.class-not-found')
            ];
        }

        if (count($invalidUsernames) > 0) {
            return [
                'status_code' => self::CREATE_STUDENTS_FAILED,
                'message' => $this->genErrorMessage($errors, $failedAttributes, $invalidUsernames)
            ];
        }

        if (count($validUsernames) > 0) {
            Account::createStudents($validUsernames, $defaultValues);
        }

        return [
            'status_code' => self::CREATE_STUDENTS_SUCCESS,
            'message' => __('message.create-successful')
        ];
    }
}
