<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Profile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('profile', function (Blueprint $table) {
            $table->id();
            $table->foreignId('musos_id')->constrained()->onDelete('cascade');
            $table->longText('presantation');
            $table->longText('mission');
            $table->longText('vision');
            $table->string('picture');
            $table->longText('value');
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
        Schema::dropIfExists('profile');
    }
}