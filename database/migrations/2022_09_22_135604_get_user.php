<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        $procedure = "DROP PROCEDURE IF EXISTS `get_users`;
        CREATE PROCEDURE `get_users` (IN idx int)
        BEGIN
            With recursive users as (

                select id, email, manager_id, 0 as permission_level
                from accounts
                where manager_id = idx

                union all

                select ac.id, ac.email, ac.manager_id, permission_level + 1
                from accounts as ac, users as us
                where ac.manager_id = us.id

            )
            SELECT us.email as employee,
                ac.email as boss,
                permission_level
            FROM users as us
            LEFT JOIN accounts as ac
            ON us.manager_id = ac.id
            ORDER BY us.permission_level, us.manager_id;
        END;";

        DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE get_users;');
    }
};
