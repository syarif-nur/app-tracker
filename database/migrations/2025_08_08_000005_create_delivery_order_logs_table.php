<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_order_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('delivery_order_id');
            $table->uuid('user_id');
            $table->string('action'); // edit, scan, upload, etc
            $table->timestamp('created_at');
            $table->text('note')->nullable();

            $table->foreign('delivery_order_id')->references('id')->on('delivery_orders');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_order_logs');
    }
};
