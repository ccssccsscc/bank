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
        Schema::create('contributions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id'); // Внешний ключ для связи с таблицей clients
            $table->decimal('amount', 10, 2); // Сумма вклада
            $table->decimal('interest_rate', 5, 2); // Процентная ставка
            $table->date('start_date'); // Дата начала вклада
            $table->date('end_date')->nullable(); // Дата окончания вклада (может быть NULL, если вклад еще активен)
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contributions');
    }
};
