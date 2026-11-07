<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payout_histories', function (Blueprint $table) {
            $table->string('user_change_percentage')->default('1')->after('payout_totalamount');
            $table->string('user_change_payment')->default('1')->after('payout_totalamount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payout_histories', function (Blueprint $table) {
            $table->string('user_change_percentage')->default('1');
            $table->string('user_change_payment')->default('1');
        });
    }
};
