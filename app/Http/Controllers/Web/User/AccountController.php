<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Base\AccountController as BaseAccountController;
use App\Models\Account;
use App\Models\ExamCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Web\WebResponseTrait;
use Illuminate\Support\Facades\DB;


class AccountController extends BaseAccountController
{
    use WebResponseTrait;

    public function statistic(Request $request)
    {
        $filter = $this->extractInput($request);

        $user = $request->session()->get(Account::TYPE_USER);

        $examResult = ExamCategory::withFilter($filter)
            ->select(DB::raw('account_exam_category.*, category.name as category_name'))
            ->join('category','account_exam_category.category_id','=','category.id')
            ->get();

        $courses = $user->allCourse;

        $categories = $user->didCategories;

        $exams = $user->didExams;

        $request->flash();
        return view('user.statistic', compact('courses', 'categories', 'exams', 'examResult'));
    }

    private function extractInput(Request $request)
    {
        return [
            'course_id' => $request->input('course'),
            'categories' => $request->input('category'),
            'exams' => $request->input('exam'),
            'from' => $request->input('from'),
            'to' => $request->input('to')
        ];
    }

}
