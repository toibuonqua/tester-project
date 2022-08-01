<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Base\ExamResultController as BaseExamResultController;
use App\Http\Controllers\Web\WebResponseTrait;
use App\Models\Account;
use App\Models\Exam;
use App\Models\ExamResult;
use Illuminate\Http\Request;

class ExamResultController extends BaseExamResultController
{
    use WebResponseTrait;

    public function stopExam(Request $request, $examid)
    {
        $functionMap = [
            'submit' => 'submitExam',
            'pause' => 'pauseExam'
        ];

        $key = $request->input('action');

        if (!array_key_exists($key, $functionMap)) {
            $this->updateFailMessage($request, "Are you trying to hack our system ?");
            return redirect(route('user.list-exam'));
        }

        $func = $functionMap[$key];

        return $this->$func($request, $examid);
    }

    public function submitExam(Request $request, $examId)
    {
        $result = $this->_saveProgress($request, $examId, ExamResult::STATUS_ACTIVATED);

        switch ($result['status_code']) {
            case self::EXAM_NOT_FOUND:
                $this->updateFailMessage($request, 'exam-not-exist');
                return redirect(route('user.list-exam'));
            case self::SAVE_PROGRESS_SUCCESSFUL:
                $this->updateSuccessMessage($request, __('message.submit-success'));
                return redirect(route('user.exam-result-detail', ['examResultId' => $result['data']->id]));
            case self::SAVE_PROGRESS_FAILED:
            default:
                $this->updateFailMessage($request, __('message.submit-failed'));
                return back()->withInput();
        }
    }

    public function pauseExam(Request $request, $examId)
    {
        $result = $this->_saveProgress($request, $examId, ExamResult::STATUS_PENDING);

        switch ($result['status_code']) {

            case self::EXAM_NOT_FOUND:
                $this->updateFailMessage($request, 'exam-not-exist');
                return redirect(route('user.list-exam'));

            case self::SAVE_PROGRESS_SUCCESSFUL:
                $this->updateSuccessMessage($request, __('message.exam-paused'));
                return redirect(route('user.list-exam'));

            case self::SAVE_PROGRESS_FAILED:
            default:
                $this->updateFailMessage($request, __('message.save-progress-failed'));
                return back()->withInput();
        }
    }



    public function resumeExam(Request $request, $examResultId)
    {
        $userId = $request->session()->get(Account::TYPE_USER)->id;
        $user = Account::find($userId);

        if ($user->isExceedAllowedExamTime()) {
            $this->updateFailMessage($request, __('message.exceed-exam-time'));
            return redirect()->back();
        }

        $examResult = ExamResult::with('examQuestionResults')
            ->with('exam.questions.answers')
            ->where('id', $examResultId)
            ->first();

        return view('user.do-exam', array_merge(
            [
                'exam' => $examResult->exam,
                'answerSheet' => $examResult->answerSheet(),
                'examResultId' => $examResultId,
                'timeLeft' => $examResult->exam->time_minute - floatval($examResult->time_minute),
                'submitTo' => route('user.do-exam', ['examId' => $examResult->exam->id])
            ]
        ));
    }


    public function list(Request $request)
    {
        $userId = $request->session()->get(Account::TYPE_USER)->id;

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
        return view('user.list-exam-result', compact('examResultItems', 'examTypes', 'examResults', 'from', 'to'));
    }


    public function get(Request $request, $examResultId)
    {
        // $examQuestion = Exam::notDeleted()->with('questions.answers')->get();
        $examResult = ExamResult::with('examQuestionResults')
            ->with('exam.questions.answers')
            ->with('account')
            ->where('id', $examResultId)
            ->firstOrFail();

        $answerSheet = $examResult->answerSheet();

        $correctNumber = $examResult->resultStatistic();

        $categoryResult = $examResult->resultCategoryStatistic();


        $examResultTypeMap = self::ExamResultTypeMap;
        $examResultValueMap = self::ExamResultValueMap;

        return view('user.exam-result-detail', compact('examResult', 'answerSheet', 'examResultTypeMap', 'examResultValueMap', 'correctNumber', 'categoryResult'));
    }
}
