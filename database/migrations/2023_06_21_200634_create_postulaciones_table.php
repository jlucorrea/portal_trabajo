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
        Schema::create('postulaciones', function (Blueprint $table) {
            $table->id();
			$table->text('descripcion')->nullable();
			$table->unsignedBigInteger('postulante_id');
			$table->unsignedBigInteger('publicacion_id');
			$table->text('archivo_pdf')->nullable();
            $table->timestamps();

			$table->foreign('postulante_id')->references('id')->on('postulante');
			$table->foreign('publicacion_id')->references('id')->on('jobs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postulaciones');
    }
};
