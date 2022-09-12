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

class WorkSpaceManagementController extends Controller
{
    use WebResponseTrait, ExportExceptOnScreen;

    // view index
    public function index() {

        $workareas = Workarea::paginate(Workarea::DEFAUL_PAGINATION);
        $exception = '';

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
        $workarea = Workarea::find($id);

        return view('workSpaceManagement.detailworkarea', compact('title', 'workarea'));
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
            $workareas = Workarea::paginate(Workarea::DEFAUL_PAGINATION);
            $exception = __('title.code-workarea-exist');
            return view('workSpaceManagement.workspacemanagement', compact('workareas', 'exception'));
        }
    }

    // Add new Workarea
    public function store(Request $request, ToastrFactory $flasher)
    {

        $request->validate([
            'work_areas_code' => 'required|unique:workarea',
            'name' => 'required',
        ]);

        $workarea = new Workarea;
        $workarea->name = $request->input('name');
        $workarea->work_areas_code = $request->input('work_areas_code');
        $workarea->createrId = Auth::id();
        $workarea->save();
        $flasher->addSuccess(__('title.notice-add-work-area-success'));
        return redirect()->route('worksm.homepage');
    }

    // Search
    public function search(Request $request)
    {
        $search_text = $request->input("query");
        $workareas = Workarea::where('name', 'like', '%'.$search_text.'%')->paginate(Workarea::DEFAUL_PAGINATION);;
        $exception = '';

        return view('workSpaceManagement.workspacemanagement', compact('workareas', 'exception'));
    }

    // Delete workarea
    public function delete($id, ToastrFactory $flasher)
    {
        $workarea = Workarea::find($id);

        try {
            $workarea->delete();
        }
        catch(\Illuminate\Database\QueryException $exception){
            Log::error("Data still in use, foreign key constraints has work area name: {$workarea->name}");
            $workareas = Workarea::paginate(Workarea::DEFAUL_PAGINATION);
            $exception = __('title.error-constraints-foreign-key');
            return view('workSpaceManagement.workspacemanagement', compact('workareas', 'exception'));
        }
        $flasher->addSuccess(__('title.notice-delete-work-area-success'));
        return redirect()->route('worksm.homepage');
    }

}
