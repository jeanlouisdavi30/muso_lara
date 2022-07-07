<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotisationCaissesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotisation_caisses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('members_id')->constrained()->onDelete('cascade');
            $table->foreignId('musos_id')->constrained()->onDelete('cascade');
            $table->foreignId('meettings_id')->constrained()->onDelete('cascade');
            $table->float('montant');
            $table->string('date_paiement')->default('0000-00-00');
            $table->string('type_caisse');
            $table->string('pay')->default('false');
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
        Schema::dropIfExists('cotisation_caisses');
    }
}