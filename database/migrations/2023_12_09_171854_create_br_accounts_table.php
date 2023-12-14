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
        Schema::create('br_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id'); // Внешний ключ для связи с таблицей clients
            $table->string('account_number')->unique(); // Уникальный номер брокерского счета
            $table->decimal('balance', 15, 2)->default(0.00); // Баланс брокерского счета
            $table->boolean('is_active')->default(true); // Флаг активности брокерского счета
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('br_accounts');
    }
};
