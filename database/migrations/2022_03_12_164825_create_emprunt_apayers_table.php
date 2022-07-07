<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpruntApayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emprunt_apayers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emprunts_id')->constrained();
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
        Schema::dropIfExists('emprunt_apayers');
    }
}