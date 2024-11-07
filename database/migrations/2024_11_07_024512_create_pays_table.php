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
        Schema::create('pays', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->decimal('amount', 8, 2);
            $table->date('date');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('state_id')->references('id')->on('states');
            // $table->foreignId('pay_type_id')->references('id')->on('pay_types'); //pensar si es necesario
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pays');
    }
};
