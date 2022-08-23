<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accounts;
use App\Models\Department;
use App\Models\Role;
use App\Models\Workarea;


class UsersManagementController extends Controller
{

    public function index(Request $request) {

        // $accounts[0]['name'];
        // $accounts[0]->name;

        $accounts = Accounts::with('role', 'department','workarea')->paginate(3);
        // $data = $accounts->links();

        foreach($accounts as $account){
            $account->role_name = $account->role->name;
            $account->department_name = $account->department->name;
            $account->workarea_code = $account->workarea->work_areas_code;
        };

        return view('userManagement.usersmanagement', compact('accounts'));
    }

    public function add() {
        $title = "Thêm Người Dùng";
        $departments = Department::all();
        $roles = Role::all();
        return view('userManagement.adduser', compact('title', 'departments', 'roles'));
    }

    public function modify($id) {

        $departments = Department::all();
        $roles = Role::all();

        $account = Accounts::with(['role', 'department'])->find($id);
        // $department = Department::find($account->department_id);
        // $role = Role::find($account->role_id);
        $workarea = Workarea::find($account->workarea_id);
        $title = 'Sửa thông tin người dùng';

        return view('userManagement.moduser', compact('title', 'account', 'workarea', 'departments', 'roles'));
    }

    public function detail($id) {

        $account = Accounts::find($id);
        $department = Department::find($account->department_id);
        $role = Role::find($account->role_id);
        $workarea = Workarea::find($account->workarea_id);
        $title = "Chi Tiết Người Dùng";

        return view('userManagement.detailuser', compact('title', 'account', 'department', 'workarea', 'role'));
    }

    public function update($id, Request $request)
    {
        $account = Accounts::query()->findOrFail($id);
        $data = $request->only('username', 'email', 'phone_number', 'status', 'code_user', 'department_id', 'role_id');
        $account->update($data);

        return redirect()->route('homepage');
    }

    public function store(Request $request)
    {

        // Không có input cho khu vực làm việc
        $account = new Accounts;
        $account->username = $request->input('username');
        $account->email = $request->input('email');
        $account->phone_number = $request->input('phone_number');
        $account->code_user = $request->input('code_user');
        $account->department_id = $request->input('department_id');
        $account->role_id = $request->input('role_id');
        $account->status = 'deactive';
        $account->password = '123';
        $account->workarea_id = '1';
        $account->save();
        return redirect()->route('homepage');
    }

    public function search(Request $request)
    {
        $search_text = $request->input("query");
        $accounts = Accounts::where('username', 'like', '%'.$search_text.'%')->with('role', 'department','workarea')->paginate(3);;
        // dd($accounts);


        foreach($accounts as $account){
            $account->role_name = $account->role->name;
            $account->department_name = $account->department->name;
            $account->workarea_code = $account->workarea->work_areas_code;
        };

        // dd($accounts);

        return view('userManagement.usersmanagement', compact('accounts'));
    }

}
