<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('nombre');
            $table->string('email')->unique();
            $table->string('email_verified_at')->nullable();//nuevo campo para adaptar el sistema a breeze
            $table->string('password');
            $table->string('contacto')->nullable();
            $table->uuid('rol_id');
            $table->boolean('activo')->default(true);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('rol_id')
                  ->references('id')
                  ->on('roles')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
