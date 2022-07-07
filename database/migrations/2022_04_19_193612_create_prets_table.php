<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePretsTable extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    

    public function up()
    {
        Schema::create('prets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('musos_id');
            $table->foreignId('members_id');
            $table->string('caisse');
            $table->string('titre');
            $table->date('date_decaissement');
            $table->float('montant');
            $table->float('pourcentage_interet');
            $table->string('duree');
            $table->string('pmensuel');
            $table->string('intere_mensuel');
            $table->string('ttalmensuel');
            $table->string('montanttotal');
            $table->string('frais')->nullable();
            $table->string('echeance');
            $table->string('statut')->nullable();
            $table->string('utilisation')->nullable();
            $table->string('comite')->default('false');
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
        Schema::dropIfExists('prets');
    }
}