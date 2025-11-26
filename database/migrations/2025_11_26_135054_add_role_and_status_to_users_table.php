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
            $table->enum('role', ['admin', 'seller', 'buyer'])
                ->default('buyer')
                ->after('password');

            $table->enum('store_status', ['pending', 'approved', 'rejected'])
                ->default('pending')
                ->nullable()
                ->after('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('store_status');
        });
    }
};
