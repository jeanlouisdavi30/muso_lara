<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meettings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('musos_id')->constrained()->onDelete('cascade');
            $table->string('title_meetting');
            $table->date('date_meetting');
            $table->longText('proces')->default();
            $table->string('fichier')->default();
            $table->string('type_fichier')->default();
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
        Schema::dropIfExists('meettings');
    }
}