<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_orders', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID
            $table->string('unique_code')->unique(); // Unique code for surat jalan
            $table->uuid('creator_id');
            $table->string('destination');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('creator_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_orders');
    }
};
