<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accounts;
use App\Models\Department;
use App\Models\Role;
use App\Models\Workarea;
use App\Http\Controllers\Web\WebResponseTrait;
use App\Common\ExportExceptOnScreen;

class WorkSpaceManagementController extends Controller
{
    use WebResponseTrait, ExportExceptOnScreen;
    public function index() {

        $workareas = Workarea::paginate(Workarea::DEFAUL_PAGINATION);
        $exception = '';

        return view('workSpaceManagement.workspacemanagement', compact('workareas', 'exception'));
    }

    public function add(Request $request) {

        $title = __('title.add-work-area');

        $error = $request->session()->get('errors');

        if ($error) {
            $this->updateFailMessage($request, $this->backString($request, $error));
        }
        return view('workSpaceManagement.addworkarea', compact('title'));
    }

    public function modify($id) {

        $title = __('title.modify-work-area');
        $workarea = Workarea::find($id);

        return view('workSpaceManagement.modworkarea', compact('title', 'workarea'));
    }

    public function detail($id) {

        $title = __('title.detail-work-area');
        $workarea = Workarea::find($id);

        return view('workSpaceManagement.detailworkarea', compact('title', 'workarea'));
    }

    public function update($id, Request $request)
    {
        try {
            $workarea = Workarea::query()->findOrFail($id);
            $workarea->name = $request->input('name');
            $workarea->work_areas_code = $request->input('work_areas_code');
            $workarea->save();
            return redirect()->route('worksm.homepage');
        }
        catch(\Illuminate\Database\QueryException $exception){
            $workareas = Workarea::paginate(Workarea::DEFAUL_PAGINATION);
            $exception = 'Mã khu vực đã tồn tại, thao tác sửa không thành công';
            return view('workSpaceManagement.workspacemanagement', compact('workareas', 'exception'));
        }
    }

    public function store(Request $request)
    {

        $request->validate([
            'work_areas_code' => 'required|unique:workarea',
            'name' => 'required',
        ]);

        $workarea = new Workarea;
        $workarea->name = $request->input('name');
        $workarea->work_areas_code = $request->input('work_areas_code');
        $workarea->status = 'ok';
        $workarea->save();
        return redirect()->route('worksm.homepage');
    }

    public function search(Request $request)
    {
        $search_text = $request->input("query");
        $workareas = Workarea::where('name', 'like', '%'.$search_text.'%')->paginate(Workarea::DEFAUL_PAGINATION);;
        $exception = '';

        return view('workSpaceManagement.workspacemanagement', compact('workareas', 'exception'));
    }

    public function delete($id)
    {
        $workarea = Workarea::find($id);

        try {
            $workarea->delete();
        }
        catch(\Illuminate\Database\QueryException $exception){
            $workareas = Workarea::paginate(Workarea::DEFAUL_PAGINATION);
            $exception = 'Khu vực vẫn còn cư dân sinh sống không thể phá hủy!!!';
            return view('workSpaceManagement.workspacemanagement', compact('workareas', 'exception'));
        }
        return redirect()->route('worksm.homepage');
    }

}
