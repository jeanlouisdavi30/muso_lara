<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->constrained()->onDelete('cascade');
            $table->foreignId('musos_id')->constrained()->onDelete('cascade');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('sexe');
            $table->date('date_birth');
            $table->string('email')->unique();
            $table->string('picture')->nullable();
            $table->boolean('actif')->nullable();
            $table->string('type_of_id')->nullable();
            $table->string('id_number')->nullable();
            $table->string('phone');
            $table->string('matrimonial_state')->nullable();
            $table->string('function')->default('member');
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
        Schema::dropIfExists('membres');
    }
}