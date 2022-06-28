<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buses', function (Blueprint $table) { 
            $table->id();
            $table->string('placa');
            $table->string('modelo');
            $table->integer('cantidad_asientos');
            $table->date('fecha_asignacion');
            $table->date('fecha_baja');
            $table->integer('numero_interno');
            $table->boolean('esta_en_recorrido');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('bus_route_id');
            $table->foreign('bus_route_id')->references('id')->on('bus_routes')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buses');
    }
};
