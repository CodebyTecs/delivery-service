<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table): void {
            $table->id();
            $table->string('sender_name');
            $table->string('recipient_name');
            $table->string('origin_city', 120);
            $table->string('destination_city', 120);
            $table->decimal('weight', 10, 2);
            $table->decimal('price', 10, 2);
            $table->string('status', 30)->default('created');
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
