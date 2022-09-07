<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Admin/IT',
                'user_manage_permission' => 1,
                'workplace_permission' => 1,
                'change_password' => 1,
                'login_logout' => 1,
                'import_goods' => 1,
                'confirm_import' => 1,
                'export_goods' => 1,
                'confirm_export' => 1,
                'packing_goods' => 1,
                'create_internal_purchase_orders' => 1,
                'delete_import_info' => 1,
                'create_internal_sales_oders' => 1,
                'status' => 'active',

            ],
            [
                'name' => 'Quản lý nhập hàng',
                'user_manage_permission' => 0,
                'workplace_permission' => 0,
                'change_password' => 1,
                'login_logout' => 1,
                'import_goods' => 1,
                'confirm_import' => 1,
                'export_goods' => 0,
                'confirm_export' => 0,
                'packing_goods' => 0,
                'create_internal_purchase_orders' => 0,
                'delete_import_info' => 1,
                'create_internal_sales_oders' => 0,
                'status' => 'active',
            ],
            [
                'name' => 'Quản lý xuất hàng',
                'user_manage_permission' => 0,
                'workplace_permission' => 0,
                'change_password' => 1,
                'login_logout' => 1,
                'import_goods' => 0,
                'confirm_import' => 0,
                'export_goods' => 0,
                'confirm_export' => 1,
                'packing_goods' => 1,
                'create_internal_purchase_orders' => 0,
                'delete_import_info' => 0,
                'create_internal_sales_oders' => 1,
                'status' => 'active',
            ],
            [
                'name' => 'Nhân viên nhập hàng',
                'user_manage_permission' => 0,
                'workplace_permission' => 0,
                'change_password' => 1,
                'login_logout' => 1,
                'import_goods' => 1,
                'confirm_import' => 0,
                'export_goods' => 0,
                'confirm_export' => 0,
                'packing_goods' => 0,
                'create_internal_purchase_orders' => 0,
                'delete_import_info' => 0,
                'create_internal_sales_oders' => 0,
                'status' => 'active',
            ],
            [
                'name' => 'Nhân viên xuất hàng',
                'user_manage_permission' => 0,
                'workplace_permission' => 0,
                'change_password' => 1,
                'login_logout' => 1,
                'import_goods' => 0,
                'confirm_import' => 0,
                'export_goods' => 1,
                'confirm_export' => 0,
                'packing_goods' => 0,
                'create_internal_purchase_orders' => 0,
                'delete_import_info' => 0,
                'create_internal_sales_oders' => 0,
                'status' => 'active',
            ],
            [
                'name' => 'Nhân viên đóng hàng',
                'user_manage_permission' => 0,
                'workplace_permission' => 0,
                'change_password' => 1,
                'login_logout' => 1,
                'import_goods' => 0,
                'confirm_import' => 0,
                'export_goods' => 0,
                'confirm_export' => 0,
                'packing_goods' => 1,
                'create_internal_purchase_orders' => 0,
                'delete_import_info' => 0,
                'create_internal_sales_oders' => 0,
                'status' => 'active',
            ],
        ];
        foreach ($roles as $key => $value) {
            Role::create($value);
        }
    }
}
