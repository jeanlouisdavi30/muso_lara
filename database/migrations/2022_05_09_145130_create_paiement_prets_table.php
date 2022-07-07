<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaiementPretsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paiement_prets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('musos_id');
            $table->foreignId('id_pret_apayers');
            $table->date('date_du_paiement');
            $table->date('date_pay');
            $table->string('numeropc');
            $table->float('montant');
            $table->float('interet_payer');
            $table->float('principale_payer');
            $table->float('balance_versement');
            $table->float('balance_tt_pret')->nullable();
            $table->string('description')->nullable();
            $table->string('statut');
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
        Schema::dropIfExists('paiement_prets');
    }
}