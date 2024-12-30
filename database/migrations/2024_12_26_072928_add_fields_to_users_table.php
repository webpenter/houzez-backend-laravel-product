<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Ensure username column exists
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->nullable(false)->after('id');
            }

            // Ensure email column exists
            if (!Schema::hasColumn('users', 'email')) {
                $table->string('email')->unique()->nullable(false)->after('username');
            }

            // Ensure password column exists
            if (!Schema::hasColumn('users', 'password')) {
                $table->string('password')->nullable(false)->after('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'username')) {
                $table->dropColumn('username');
            }

            if (Schema::hasColumn('users', 'email')) {
                $table->dropColumn('email');
            }

            if (Schema::hasColumn('users', 'password')) {
                $table->dropColumn('password');
            }
        });
    }
};
