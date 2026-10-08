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
        Schema::create('actores', function (Blueprint $table) {
            $table->id();
            $table->integer('pelicula_id');
            $table->string('nombre');
            $table->foreign('pelicula_id')
                ->references('id')
                ->on('peliculas')
                ->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('personajes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('actor_id');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->foreign('actor_id')
                ->references('id')
                ->on('actores')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personajes');
        Schema::dropIfExists('actores');
    }
};
