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
        Schema::create('postulante', function (Blueprint $table) {
			$table->id();
            $table->string('tipo_doc');
            $table->string('numero');
            $table->string('nombre');
            $table->string('apellidos');
            $table->date('f_nacimiento');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postulante');
    }
};
