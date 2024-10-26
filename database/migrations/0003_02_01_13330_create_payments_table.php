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
        /* Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('child_id'); // Foreign key to child
            $table->foreign('child_id')->references('id')->on('children')->onDelete('cascade');
            $table->date('payment_date')->nullable();
            $table->float('payment_amount')->nullable();
            $table->string('payment_description')->nullable();
            $table->timestamps();
        }); */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
