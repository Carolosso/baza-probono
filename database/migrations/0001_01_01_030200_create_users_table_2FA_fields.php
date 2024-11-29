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

        Schema::table('users', function (Blueprint $table) {
            $table->date('two_factor_confirmed_at')->nullable();         
            $table->string('google2fa_secret')->nullable();         
            $table->boolean('two_factor_enabled')->default(0);    
            $table->boolean('two_factor_verified')->default(0);     
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('google2fa_secret');
            $table->dropColumn('two_factor_enabled');
            $table->dropColumn('two_factor_verified');
        });
    }
};
