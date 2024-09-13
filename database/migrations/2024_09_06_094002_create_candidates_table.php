<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('dob');
            $table->string('pob');
            $table->string('email');
            $table->string('phone_number');
            $table->string('photo')->nullable();
            $table->string('ktp_address');
            $table->string('current_address');
            $table->string('npwp_number');
            $table->string('ktp_number');
            $table->string('kk_number');
            $table->string('religion');
            $table->string('nationality');
            $table->integer('height');
            $table->integer('weight');
            $table->enum('gender', ['LAKI-LAKI', 'PEREMPUAN']);
            $table->date('date_applied')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('candidates');
    }
};
