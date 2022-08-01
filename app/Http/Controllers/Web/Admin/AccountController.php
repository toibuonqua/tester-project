<?php

namespace App\Http\Controllers\Web\Admin;


use App\Common\MailSender;
use App\Models\Account;
use App\Models\ExamResult;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Web\AccountController as BaseController;

// Common Trait

use App\Http\Controllers\Web\WebResponseTrait;
use App\Http\Controllers\Web\PaginationTrait;
use App\Mail\RegisterMail;
use App\Models\Classroom;
use App\Models\Course;
use Carbon\Carbon;
use Throwable;

class AccountController extends BaseController
{
    use WebResponseTrait, PaginationTrait;

    public function get(Request $request, $id)
    {
        $user = Account::find($id);

        if (!$user) {
            $this->updateFailMessage($request, __('message.account-not-found'));
            return redirect()->route('admin-dashboard');
        }

        if ($user->isAssistant()) {
            $this->updateFailMessage($request, __('message.assistant-cant-update'));
            return redirect()->route('admin-dashboard');
        }

        $courses = Course::all();
        return view('admin.account-detail', compact('courses', 'user'));
    }

    public function create(Request $request, $type)
    {
        $classes = Classroom::orderBy('created_at', 'desc')->get();
        $expiredAt = Carbon::now()->addMonths(Account::EXPIRED_IN_MONTH);

        if ($type == self::CREATE_ASSISTANT_ACCOUNT) {
            return view('admin.assistant-account-create', compact('classes'));
        }
        return view('account.student-account-create', compact('classes', 'expiredAt'));
    }

    /**
     * Create new accounts
     *
     * @param Request $request
     *
     */
    public function save(Request $request)
    {
        $createType = $request->input('create-account-type');

        try {
            if ($createType == self::CREATE_ASSISTANT_ACCOUNT) {
                return $this->createAssistant($request);
            }

            return $this->createStudents($request);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $this->updateFailMessage($request, __('message.create-fail') . ' ' . $e->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Update an account's info (course, expired time)
     *
     * @param Request $request
     * @param int $id id of account to be updated
     */
    public function updateAccountInfo(Request $request, $id)
    {
        $action = $request->input('action');

        $user = Account::where('id', $id)->first();
        if (!$user) {
            $this->updateFailMessage($request, 'Account id not exist');
            return back();
        }

        if ($action == 'send-verify') {
            return $this->sendVerificationLink($request, $user);
        }

        $updateData = [
            'course_id' => $request->input('course'),
            'expired_at' => $request->input('expired-at'),
            'today_exam_time_minute' => $request->input('current-day-time-minute')
        ];

        try {
            $user->update($updateData);
            $this->updateSuccessMessage($request, __('message.update-successful'));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $this->updateFailMessage($request, __('message.update-fail'));
        }
        return redirect()->route('get-account', ['id' => $id]);
    }

    /**
     * Show dashboard for managing users
     *
     * @param Request $request
     */
    public function listAccount(Request $request)
    {
        $searchParams = $this->extractSearchParams($request);

        if ($request->method() == 'POST') {
            return redirect()->route('admin-dashboard', $searchParams);
        }

        [
            'accounts' => $users,
            'paginationParams' => $paginationParams
        ] = $this->searchAccounts($request, $searchParams);

        $classes = Classroom::orderBy('created_at', 'desc')->get();
        $statusOptions = self::DEFAULT_STATUS_SELECT;

        ['type' => $type] = $searchParams;
        if ($type == Account::TYPE_USER) {
            return view('admin.student-list', array_merge(
                $this->extractMessage($request),
                $searchParams,
                $paginationParams,
                compact('classes', 'users', 'statusOptions')
            ));
        }

        return view('admin.assistant-list', array_merge(
            $this->extractMessage($request),
            $searchParams,
            $paginationParams,
            compact('classes', 'users', 'statusOptions')
        ));
    }

    /**
     * Handle action when user update status
     *
     * @param Request $request
     */
    public function updateStatus(Request $request)
    {
        $type = $request->input('type');

        $result = $this->updateAccountStatus($request);
        switch ($result['status_code']) {
            case self::UPDATE_STATUS_SUCCESS:
                $this->updateSuccessMessage($request, $result['message']);
                return redirect(route('admin-dashboard', ['type' => $type]));
            case self::UPDATE_STATUS_FAILED:
            default:
                $this->updateFailMessage($request, $result['message']);
                return back()->withInput();
        }
    }

    public function updateNumberPerPage(Request $request)
    {
        $this->updateNumberPerPageSession($request, $request->input('numberPerPage'));

        $this->updateMessage($request, __('message.update-successful'), 'success');

        return redirect(route('admin-dashboard'));
    }

    public function listExamResult(Request $request, $userId)
    {
        $examTypes = $request->input('exam-type', ['first_attempt', 'again']);
        $examResults = $request->input('exam-result', ['failed', 'passed']);
        $from = $request->input('from', date('Y-m-d', strtotime('-1 month')));
        $to = $request->input('to', date('Y-m-d', strtotime('1 day')));

        $examResultItems = ExamResult::withFilter($userId, $examTypes, $examResults, $from, $to)
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($examResultItems as $examResultItem) {
            $examResultItem->exam_name = $examResultItem->exam->name;
        }
        return view('admin.user-exam-result', compact('userId', 'examResultItems', 'examTypes', 'examResults', 'from', 'to'));
    }

    /**
     * Send verification link to activate pending user
     *
     * @param Request $request
     * @param Account $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws Throwable
     */
    private function sendVerificationLink(Request $request, $user)
    {
        try {
            MailSender::send(RegisterMail::class, $user);
            $user->save();

            $this->updateSuccessMessage($request, __('message.send-verification-link-success'));
            return redirect()->route('get-account', ['id' => $user->id]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $this->updateFailMessage($request, 'Cannot send mail: ' . $e->getMessage());
        }
    }


    private function createStudents(Request $request)
    {
        $result = $this->_createStudents($request);
        switch ($result['status_code']) {

            case self::CREATE_STUDENTS_SUCCESS:
                $this->updateSuccessMessage($request, $result['message']);
                return redirect(route('admin-dashboard'));

            case self::CREATE_STUDENTS_FAILED:
            default:
                $this->updateFailMessage($request, $result['message']);
                return back()->withInput();
        }
    }

    /**
     * Validation for creating class assistant account
     *
     * @throws Exception if validator fails
     */
    private function validateAssistantInput(Request $request)
    {
        $validator = $this->makeAccountValidator($request->all());

        if ($validator->fails()) {
            $errMsg = '';
            foreach ($validator->errors()->all() as $msg) {
                $errMsg .= $msg . '<br/>';
            }
            throw new Exception($errMsg);
        }
    }

    private function createAssistant(Request $request)
    {
        try {
            $this->validateAssistantInput($request);
        } catch (Throwable $th) {
            Log::error($th->getMessage());
            $this->updateFailMessage($request, $th->getMessage());
            return back()->withInput();
        }

        $insertData = $request->only(['username', 'email', 'password']) + [
            'type' => Account::TYPE_CLASS_ASSISTANT,
            'class_id' => $request->input('class'),
            'expired_at' => null
        ];

        try {
            $assistant = Account::createAsistant($insertData);
            $assistant->save();

            if ($insertData['class_id']) {
                $assistant->managedClasses()->attach($insertData['class_id'] + 123);
            }
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            $assistant->delete();
            $this->updateFailMessage($request, __('message.create-fail') . " " . $e->getMessage());
            return back()->withInput();
        }

        try {
            $details = [
                "email" => $assistant->email,
                "name" => $assistant->username,
                "verificationKey" => $assistant->access_token,
                "username" => $assistant->username
            ];
            MailSender::send(RegisterMail::class, $details);
        } catch (\Throwable $e) {

            $assistant->managedClasses()->sync([]);
            $assistant->delete();
            Log::error($e->getMessage());
            $this->updateFailMessage($request, 'Cannot send mail: ' . $e->getMessage());
            return back()->withInput();
        }

        $this->updateSuccessMessage($request, __('message.create-successful'));
        return redirect()->route('admin-dashboard', ['type' => Account::TYPE_CLASS_ASSISTANT]);
    }
}
