<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Flasher\Toastr\Prime\ToastrFactory;
use App\Http\Controllers\Web\WebResponseTrait;
use App\Common\ExportExceptOnScreen;
use App\Exports\DepartmentExport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Flasher\SweetAlert\Prime\SweetAlertFactory;
use Maatwebsite\Excel\Facades\Excel;

class DepartmentController extends Controller
{
    use WebResponseTrait, ExportExceptOnScreen;

    // view home page
    public function index(Request $request)
    {
        $departments = Department::paginate(Department::DEFAULT_PAGINATION);
        $query = '';
        $request->session()->put('query', $query);

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

    // add new department
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

    // view modify
    public function modify($id)
    {
        $department = Department::find($id);

        return view('Department.modify', compact('department'));
    }

    // Update department
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
            $exception = "Phòng ban đã tồn tài hoặc ô điền bị trống";
            $flasher->addError($exception);
            return back();
        }
    }

    // view detail
    public function detail($id)
    {
        $department = Department::with('accounts')->find($id);
        $department->employee = count($department->accounts);

        return view('Department.detail', compact('department'));
    }

    // Delete department
    public function delete($id, ToastrFactory $flasher, SweetAlertFactory $flasher1)
    {
        $department = Department::with('accounts')->find($id);
        if (count($department->accounts) > 0)
        {
            $flasher1->addError('Phòng ban còn nhân sự, không thể xóa');
            return back();
        }
        $department->delete();
        $flasher->addSuccess(__('title.notice-delete-department-success'));
        return back();
    }

    // search bar
    public function search(Request $request)
    {
        $query = $request->input('query');
        $departments = Department::with('accounts')->where('name', 'like', '%'.$query.'%')->paginate(Department::DEFAULT_PAGINATION);
        $request->session()->put('query', $query);

        return view('Department.index', compact('departments'));
    }

    // export excel
    public function export(Request $request)
    {
        $keyword = $request->session()->get('query');
        $departments = Department::where('name', 'like', '%'.$keyword.'%')->get();
        $time = Carbon::now()->format('YmdHi');
        return Excel::download(new DepartmentExport($departments),  'DanhSachPhongBan_'.$time.'.xlsx');
    }

}
