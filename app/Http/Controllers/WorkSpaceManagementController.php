<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accounts;
use App\Models\Department;
use App\Models\Role;
use App\Models\Workarea;
use App\Http\Controllers\Web\WebResponseTrait;
use App\Common\ExportExceptOnScreen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Flasher\Toastr\Prime\ToastrFactory;
use Flasher\SweetAlert\Prime\SweetAlertFactory;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WorkareaExport;
use Carbon\Carbon;

class WorkSpaceManagementController extends Controller
{
    use WebResponseTrait, ExportExceptOnScreen;

    // view index
    public function index(Request $request) {
        $workareas = Workarea::paginate(Workarea::DEFAUL_PAGINATION);
        foreach ($workareas as $workarea) {
            if ($workarea->createrId == null){
                $workarea->creater = '';
            }
            else{
                $creater = Accounts::find($workarea->createrId);
                $workarea->creater = $creater->username;
            }
        }
        $exception = '';
        $query = '';
        $request->session()->put('query', $query);

        return view('workSpaceManagement.workspacemanagement', compact('workareas', 'exception'));
    }

    // view add
    public function add(Request $request) {

        $title = __('title.add-work-area');

        $error = $request->session()->get('errors');

        if ($error) {
            $this->updateFailMessage($request, $this->backString($request, $error));
        }
        return view('workSpaceManagement.addworkarea', compact('title'));
    }

    // view modify
    public function modify($id) {

        $title = __('title.modify-work-area');
        $workarea = Workarea::find($id);

        return view('workSpaceManagement.modworkarea', compact('title', 'workarea'));
    }

    // view detail
    public function detail($id) {

        $title = __('title.detail-work-area');
        $workarea = Workarea::with('accounts')->find($id);
        $many_user = count($workarea->accounts);

        return view('workSpaceManagement.detailworkarea', compact('title', 'workarea', 'many_user'));
    }

    // update info workarea
    public function update($id, Request $request, ToastrFactory $flasher)
    {
        try {
            $workarea = Workarea::query()->findOrFail($id);
            $workarea->name = $request->input('name');
            $workarea->work_areas_code = $request->input('work_areas_code');
            $workarea->save();
            $flasher->addSuccess(__('title.notice-modify-workarea-success'));
            return redirect()->route('worksm.homepage');
        }
        catch(\Illuminate\Database\QueryException $exception){
            Log::error('code work area was exist');
            $exception = __('title.code-workarea-exist');
            $flasher->addError($exception);
            return back();
        }
    }

    // Add new Workarea
    public function store(Request $request, ToastrFactory $flasher)
    {

        $request->validate([
            'work_areas_code' => 'required|unique:workarea|max:6',
            'name' => 'required|max:6',
        ]);

        $workarea = new Workarea;
        $workarea->name = $request->input('name');
        $workarea->work_areas_code = $request->input('work_areas_code');
        $workarea->createrId = Auth::id();
        $workarea->save();
        $flasher->addSuccess(__('title.notice-add-work-area-success'));
        return redirect()->route('worksm.homepage');
    }

    // Search bar
    public function search(Request $request)
    {
        $query = $request->input("query");
        $workareas = Workarea::where('name', 'like', '%'.$query.'%')->paginate(Workarea::DEFAUL_PAGINATION);
        foreach ($workareas as $workarea) {
            if ($workarea->createrId == null){
                $workarea->creater = '';
            }
            else{
                $creater = Accounts::find($workarea->createrId);
                $workarea->creater = $creater->username;
            }
        }

        $exception = '';
        $request->session()->put('query', $query);

        return view('workSpaceManagement.workspacemanagement', compact('workareas', 'exception'));
    }

    // export excel
    public function export(Request $request)
    {
        $query = $request->session()->get('query');
        $workareas = Workarea::where('name', 'like', '%'.$query.'%')->orderBy('created_at', 'DESC')->get();
        foreach ($workareas as $workarea) {
            if ($workarea->createrId == null){
                $workarea->creater = '';
            }
            else{
                $creater = Accounts::find($workarea->createrId);
                $workarea->creater = $creater->username;
            }
        }
        $time = Carbon::now()->format('YmdHi');
        return Excel::download(new WorkareaExport($workareas),  'DanhSachKVLV_'.$time.'.xlsx');
    }

    // Delete workarea
    public function delete($id, ToastrFactory $flasher, SweetAlertFactory $flasher1)
    {
        $workarea = Workarea::find($id);

        try {
            $workarea->delete();
        }
        catch(\Illuminate\Database\QueryException $exception){
            Log::error("Data still in use, foreign key constraints has workarea name: {$workarea->name}");
            $exception = __('title.error-constraints-foreign-key');
            $flasher1->addError($exception);
            return back();
        }
        $flasher->addSuccess(__('title.notice-delete-work-area-success'));
        return back();
    }

}
