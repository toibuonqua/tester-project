<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('user_manage_permission');
            $table->string('workplace_permission');
            $table->string('change_password');
            $table->string('login_logout');
            $table->string('import_goods');
            $table->string('confirm_import');
            $table->string('export_goods');
            $table->string('confirm_export');
            $table->string('packing_goods');
            $table->string('create_internal_purchase_orders');
            $table->string('delete_import_info');
            $table->string('create_internal_sales_oders');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role');
    }
};
