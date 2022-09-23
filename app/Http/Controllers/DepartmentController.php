<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Flasher\Toastr\Prime\ToastrFactory;
use App\Http\Controllers\Web\WebResponseTrait;
use App\Common\ExportExceptOnScreen;
use Illuminate\Support\Facades\Log;

use function Symfony\Component\String\b;

class DepartmentController extends Controller
{
    use WebResponseTrait, ExportExceptOnScreen;

    // view home page
    public function index()
    {
        $departments = Department::paginate(Department::DEFAULT_PAGINATION);

        return view('Department.index', compact('departments'));
    }

    // view add
    public function add(Request $request)
    {
        $error = $request->session()->get('errors');

        if ($error) {
            $this->updateFailMessage($request, $this->backString($request, $error));
        }

        return view('Department.add');
    }

    public function store(Request $request, ToastrFactory $flasher)
    {

        $request->validate([
            'name' => 'required|unique:department',
        ]);

        $department = new Department;
        $department->name = $request->input('name');
        $department->save();
        $flasher->addSuccess(__('title.notice-add-department-success'));
        return redirect()->route('department.homepage');

    }

    public function modify($id)
    {
        $department = Department::find($id);

        return view('Department.modify', compact('department'));
    }

    public function update($id, Request $request, ToastrFactory $flasher)
    {
        try {
            $department = Department::query()->findOrFail($id);
            $department->name = $request->input('name');
            $department->save();
            $flasher->addSuccess(__('title.notice-modify-department'));
            return redirect()->route('department.homepage');
        }
        catch(\Illuminate\Database\QueryException $exception){
            Log::error('field in FE of department is empty or duplicate in database');
            $exception = "Phòng ban không tồn tài hoặc ô điền bị trống";
            $flasher->addError($exception);
            return back();
        }
    }

    public function detail()
    {
        return view('Department.detail');
    }

    public function delete()
    {
        //
    }

}
