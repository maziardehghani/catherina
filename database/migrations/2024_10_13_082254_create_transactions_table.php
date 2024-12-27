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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id');
            $table->unsignedBigInteger('amount');
            $table->unsignedInteger('status_id');
            $table->string('terminal_id')->nullable();
            $table->string('trace_number');
            $table->string('rrn')->nullable();
            $table->string('secure_pan')->nullable();
            $table->string('token',255)->nullable();
            $table->enum('gateWay',['receipt','online']);

            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
