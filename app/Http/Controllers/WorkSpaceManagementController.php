<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accounts;
use App\Models\Department;
use App\Models\Role;
use App\Models\Workarea;

class WorkSpaceManagementController extends Controller
{
    public function index() {

        $workareas = Workarea::paginate(5);
        $exception = '';

        return view('workSpaceManagement.workspacemanagement', compact('workareas', 'exception'));
    }

    public function add() {

        $title = __('title.add-work-area');
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
        $workarea = Workarea::query()->findOrFail($id);
        $workarea->name = $request->input('name');
        $workarea->work_areas_code = $request->input('work_areas_code');
        $workarea->save();

        return redirect()->route('worksm.homepage');
    }

    public function store(Request $request)
    {

        $validatedDatas = $request->validate([
            'work_areas_code' => 'required|unique:workarea',
            'name' => 'required',
        ]);

        $workarea = new Workarea;
        $workarea->name = $request->input('name');
        $workarea->work_areas_code = $request->input('work_areas_code');
        $workarea->status = 'ok';
        $workarea->save();
        return redirect()->route('worksm.homepage');
        // try {
        //     $workarea->save();
        //     return redirect()->route('worksm.homepage');
        // }
        // catch(Exception $e) {
        //     return "a";
        // }
        // catch(\Illuminate\Database\QueryException $e) {
        //     return back();
        // }
    }

    public function search(Request $request)
    {
        $search_text = $request->input("query");
        $workareas = Workarea::where('name', 'like', '%'.$search_text.'%')->paginate(5);;

        return view('workSpaceManagement.workspacemanagement', compact('workareas'));
    }

    public function delete($id)
    {
        $workarea = Workarea::find($id);

        try {
            $workarea->delete();
        }
        catch(\Illuminate\Database\QueryException $exception){
            $workareas = Workarea::paginate(5);
            $exception = 'Khu vực vẫn còn cư dân sinh sống không thể phá hủy!!!';
            return view('workSpaceManagement.workspacemanagement', compact('workareas', 'exception'));
        }
        return redirect()->route('worksm.homepage');
    }

}
