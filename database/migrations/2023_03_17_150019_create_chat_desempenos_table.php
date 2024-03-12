<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatDesempenosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_desempenos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("desempeno_id");
            $table->unsignedBigInteger("emisor_id");
            $table->unsignedBigInteger("receptor_id");
            $table->text("mensaje");
            $table->integer("visto");
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
        Schema::dropIfExists('chat_desempenos');
    }
}
