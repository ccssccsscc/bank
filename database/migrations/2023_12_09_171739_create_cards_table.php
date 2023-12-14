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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('NumberCard');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('balance');
            $table->string('CVV', 3); // Используем string и устанавливаем ограничение на 3 символа
            $table->enum('type', ['credit', 'debit']);
            $table->string('DateFinish', 10); // Используем string и устанавливаем ограничение на 10 символов
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
