<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('don', function (Blueprint $table) {
            $table->id();
            $table->foreignId('musos_id')->constrained();
            $table->foreignId('partenaire_id')->constrained();
            $table->string('titre');
            $table->float('montant');
            $table->date('date_decaissement');
            $table->string('numero_cb');
            $table->longText('description');
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
        Schema::dropIfExists('don');
    }
}