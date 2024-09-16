<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add 'username' only if it doesn't already exist
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username', 80)->unique()->nullable(false)->after('id');
            }

            // Adjust 'password', 'role', 'temp_password', and 'is_temp_password' fields
            $table->string('password', 500)->nullable(false)->change();
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role', 20)->nullable(false)->after('password');
            }
            if (!Schema::hasColumn('users', 'temp_password')) {
                $table->string('temp_password', 256)->nullable()->after('password');
            }
            if (!Schema::hasColumn('users', 'is_temp_password')) {
                $table->boolean('is_temp_password')->default(false)->after('temp_password');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('role');
            $table->dropColumn('temp_password');
            $table->dropColumn('is_temp_password');
        });
    }
}
