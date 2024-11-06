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

        //=============================> Tabla de states <=============================
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
        });


        //=============================> Tabla de Roles <=============================
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('descripcion');
        });


        //====================================>Tabla de Academias <====================================
        Schema::create('academys', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->integer('rating');
        });

        //=============================> Tabla Users <=============================
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamps();
            $table->timestamp('date_of_birth')->nullable();
            $table->string('phone');
            $table->string('specialty_id')->references('id')->on('specialtys')->nullable();;
            $table->timestamp('hiring_date')->nullable();
            $table->foreignId('state_id')->references('id')->on('states');
        });


        //=============================> Tabla de role_user <=============================
        Schema::create('role_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('role_id')->references('id')->on('roles')->onDelete('cascade');
        });

        //=============================> Tabla de academia_usuarios <=============================
        Schema::create('academy_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academy_id')->references('id')->on('academys')->onDelete('cascade');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
        });


        //=============================> Tabla Classes <=============================
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academy_id')->references('id')->on('academys')->onDelete('cascade');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name');
            $table->string('description');
            $table->integer('capacity');
            $table->integer('duration');
            $table->integer('price');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('state');
        });

        //=============================> Tabla class_user <=============================
        Schema::create('class_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            // $table->string('role')->nullable(); // rol en la clase (e.g., estudiante, instructor)
        });

        //=============================> Tabla de Servicios de academias <=============================
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academy_id')->references('id')->on('academys')->onDelete('cascade');
            $table->string('name');
            $table->string('description');
            $table->integer('price');
        });





        //=============================> Tabla de content_type <=============================
        Schema::create('content_types', function (Blueprint $table) {
            $table->id();
            $table->string('app_label');
            $table->string('model');
        });

        //=============================> Tabla de permissions <=============================
        Schema::create('auth_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_type_id')->references('id')->on('content_types')->onDelete('cascade');
            $table->string('name');
            $table->string('codename');
        });

        //=============================> Tabla de user_permission <=============================
        Schema::create('auth_user_permission', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('permission_id')->references('id')->on('auth_permissions')->onDelete('cascade');
        });

        //=============================> Tabla de group<=============================
        Schema::create('auth_group', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        //=============================> Tabla de group_permission <=============================
        Schema::create('auth_group_permission', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->references('id')->on('auth_group')->onDelete('cascade');
            $table->foreignId('permission_id')->references('id')->on('auth_permissions')->onDelete('cascade');
        });

        //=============================> Tabla de group_user <=============================
        Schema::create('auth_group_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->references('id')->on('auth_group')->onDelete('cascade');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
        });



        // Schema::create('permisos', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('descripcion');
        //     $table->foreignId('rol_id')->references('id')->on('roles');
        // });

        //======================================> Tabla de specialtys <======================================
        Schema::create('specialtys', function (Blueprint $table) {
            $table->id();
            $table->string('description');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // Schema::create('gastos_contables', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('concepto');
        //     $table->date('fecha_gasto');
        //     $table->decimal('monto', 8, 2);
        //     $table->foreignId('usuario_id')->references('id')->on('users');
        // });

        // Schema::create('ingresos_contables', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('concepto');
        //     $table->date('fecha_ingreso');
        //     $table->decimal('monto', 8, 2);
        //     $table->foreignId('usuario_id')->references('id')->on('users');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('roles');
        // Schema::dropIfExists('permisos');
        // Schema::dropIfExists('gastos_contables');
        // Schema::dropIfExists('ingresos_contables');
        Schema::dropIfExists('academys');
        Schema::dropIfExists('academy_users');
        Schema::dropIfExists('classes');
        Schema::dropIfExists('class_user');
        Schema::dropIfExists('services');
        Schema::dropIfExists('states');
        Schema::dropIfExists('content_types');
    }
};
