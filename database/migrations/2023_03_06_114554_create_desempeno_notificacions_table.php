<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesempenoNotificacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('desempeno_notificacions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("desempeno_id");
            $table->date("fecha");
            $table->time("hora");
            $table->text("desempeno");
            $table->string("valoracion");
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
        Schema::dropIfExists('desempeno_notificacions');
    }
}
