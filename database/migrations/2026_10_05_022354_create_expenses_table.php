<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//migraciones son una forma de versionar la base de datos, permitiendo crear, modificar y eliminar tablas y
//  columnas de manera controlada y reversible.

//perime crear relaciones entre tablas, como en este caso, 
// donde se establece una relación entre la tabla de gastos 
// y las tablas de usuarios y películas,
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->float('monto', 10, 2);
            $table->integer('usuario_id');
            $table->integer('pelicula_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios');
            $table->foreign('pelicula_id')->references('id')->on('peliculas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
