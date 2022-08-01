<?php

namespace App\Http\Controllers\Web\User;

use App\Common\ExtractList;
use App\Http\Controllers\Base\ExamController as BaseExamController;
use App\Http\Controllers\Web\WebResponseTrait;
use App\Models\Account;
use App\Models\Category;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamController extends BaseExamController
{
    use WebResponseTrait;

    public function listExam(Request $request)
    {
        [
            'exams' => $exams,
            'course'=> $courses
        ] = $this->_getExamList($request);

        $user = $request->session()->get(Account::TYPE_USER);
        $pendingExamResults = $this->getPendingExamResults($user->id);

        return view('user.list-exam', compact('exams', 'pendingExamResults', 'courses'));
    }

    public function doExam(Request $request, $examId)
    {
        $userId = $request->session()->get(Account::TYPE_USER)->id;
        $user = Account::find($userId);

        if ($user->isExceedAllowedExamTime()) {
            $this->updateFailMessage($request, __('message.exceed-exam-time'));
            return redirect()->back();
        }

        $request->session()->put('startTime', now());

        [
            'status_code' => $statusCode,
            'data' => $exam
        ] = $this->_getDetailExam($request, $examId);

        if ($exam->isHidden()) {
            $this->updateFailMessage($request, __('message.exam-hidden'));
            return back();
        }

        $user = $request->session()->get(Account::TYPE_USER);
        if ($user->isExceedNumOfAttempts($exam)) {
            $this->updateFailMessage($request, __('message.exceed-num-attempts', ['num_attempts' => $exam->num_attempts]));
            return back();
        }

        $request->session()->put('startTime', now());
        $timeLeft = $exam->time_minute;

        return view('user.do-exam', compact('exam', 'timeLeft'));
    }

    public function practice(Request $request)
    {
        $categories = Category::all();

        [
            'exams' => $exams,
            'course'=> $courses
        ] = $this->_getExamList($request,true);

        $questionQuantity = Question::getQuestionQuantity($courses->map(fn($course) => $course->id)->all());

        $typeOptions = [
            'exam' => Exam::PRACTICE_BY_EXAM,
            'category' => Exam::PRACTICE_BY_CATEGORY
        ];

        $exams = $exams->sortByDesc('id');

        return view('user.practice', compact('courses', 'categories', 'exams','typeOptions','questionQuantity'));
    }

    public function generateExam(Request $request)
    {
        $user = $request->session()->get(Account::TYPE_USER);
        $account = Account::find($user->id);

        if (!$account->updated_at->isToday()){
            $account->resetExamCreateLimit();
            $account->save();
        }

        if ($account->today_exam_created >= Account::ALLOWED_EXAM_CREATE) {
            $this->updateFailMessage($request, __('message.exceed-exam-created'));
            return back();
        }

        $result = $this->_generateExam($request);

        switch ($result['status_code']){
            case self::GENERATE_EXAM_SUCCESS:
                $account->today_exam_created +=1;
                $account->save();

                $this->updateSuccessMessage($request,$result['message']);
                return back();
            case self::GENERATE_EXAM_FAILED:
            default:
                $this->updateFailMessage($request,$result['message']);
                return back()->withInput();
        }

    }
}
