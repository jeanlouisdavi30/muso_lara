<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePretApayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pret_apayers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prets_id');
            $table->foreignId('musos_id')->constrained();
            $table->string('pmensuel');
            $table->string('intere_mensuel');
            $table->string('ttalmensuel');
            $table->string('paiement');
            $table->string('date_paiement');
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
        Schema::dropIfExists('pret_apayers');
    }
}