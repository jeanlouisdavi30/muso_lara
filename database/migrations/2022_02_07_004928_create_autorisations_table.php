<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutorisationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autorisations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('musos_id')->constrained()->onDelete('cascade');
            $table->foreignId('members_id')->constrained()->onDelete('cascade');
            $table->string('password');
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
        Schema::dropIfExists('autorisations');
    }
}