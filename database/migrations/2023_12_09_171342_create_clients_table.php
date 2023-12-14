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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->text('FIO')->nullable(false);
            $table->enum('lizo', ['fiz', 'yr'])->nullable(false);
            $table->integer('CountBrAccount')->default(0);
            $table->integer('CountCard')->default(0);
            $table->integer('CountContribution')->default(0);
            $table->text('Pincode');
            $table->unsignedBigInteger('AllBalance')->nullable(false);
            $table->string('role')->default('user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
