<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_order_receipts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('delivery_order_id');
            $table->string('photo_path');
            $table->string('receiver_name');
            $table->timestamp('received_at');
            $table->timestamps();

            $table->foreign('delivery_order_id')->references('id')->on('delivery_orders');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_order_receipts');
    }
};
