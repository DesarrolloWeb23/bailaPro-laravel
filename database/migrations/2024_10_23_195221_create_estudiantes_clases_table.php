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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->date('fecha_nacimiento');
            $table->date('fecha_registro');
            $table->string('nombre');
            $table->string('telefono');
        });

        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->string('concepto');
            $table->date('fecha_pago');
            $table->decimal('monto', 8, 2);
            $table->foreignId('estudiante_id')->references('id')->on('estudiantes');
        });

        Schema::create('profesores', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('especialidad');
            $table->date('fecha_contratacion');
            $table->string('nombre');
            $table->string('telefono');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });

        Schema::create('clases', function (Blueprint $table) {
            $table->id();
            $table->integer('capacidad');
            $table->integer('duracion');
            $table->string('horario');
            $table->string('nombre');
            $table->foreignId('profesor_id')->references('id')->on('profesores');
        });

        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_inscripcion');
            $table->foreignId('clase_id')->references('id')->on('clases');
            $table->foreignId('estudiante_id')->references('id')->on('estudiantes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clases');
        Schema::dropIfExists('profesores');
        Schema::dropIfExists('pagos');
        Schema::dropIfExists('estudiantes');
    }
};
