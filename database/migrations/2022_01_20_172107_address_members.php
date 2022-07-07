<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddressMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('members_id')->constrained()->onDelete('cascade');
            $table->string('address');
            $table->string('city');
            $table->string('arondisment');
            $table->string('departement');
            $table->string('pays');
            $table->string('language');
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
         Schema::dropIfExists('address_members');
    }
}