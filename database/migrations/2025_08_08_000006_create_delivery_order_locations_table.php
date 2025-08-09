<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_order_locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('delivery_order_id');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('ip_address')->nullable();
            $table->string('device_info')->nullable();
            $table->timestamp('scanned_at');
            $table->uuid('scanned_by');
            $table->timestamps();

            $table->foreign('delivery_order_id')->references('id')->on('delivery_orders');
            $table->foreign('scanned_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_order_locations');
    }
};
