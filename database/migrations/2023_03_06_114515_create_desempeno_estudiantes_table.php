<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesempenoEstudiantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('desempeno_estudiantes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("inscripcion_id");
            $table->unsignedBigInteger("materia_id");
            $table->unsignedBigInteger("estudiante_id");
            $table->text("desempeno");
            $table->string("valoracion", 255);
            $table->date("fecha");
            $table->text("observacion")->nullable();
            $table->unsignedBigInteger("user_id");
            $table->date("fecha_registro");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('desempeno_estudiantes');
    }
}
