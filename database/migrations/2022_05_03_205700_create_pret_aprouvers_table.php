<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePretAprouversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pret_aprouvers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prets_id');
            $table->foreignId('musos_id');
            $table->float('old_montant');
            $table->float('new_montant');
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
        Schema::dropIfExists('pret_aprouvers');
    }
}
