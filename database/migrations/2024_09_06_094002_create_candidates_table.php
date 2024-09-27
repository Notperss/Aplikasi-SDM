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
            $table->date('dob');
            $table->string('pob');
            $table->string('email');
            $table->string('phone_number');
            $table->string('photo')->nullable();
            $table->text('ktp_address');
            $table->text('current_address');
            // $table->string('npwp_number');
            $table->string('ktp_number');
            $table->string('kk_number');
            $table->string('religion');
            $table->string('nationality');
            // $table->integer('height');
            // $table->integer('weight');
            $table->enum('gender', ['LAKI-LAKI', 'PEREMPUAN']);
            $table->date('date_applied')->nullable();

            $table->boolean('is_qualify')->default(true);
            $table->boolean('is_hire')->default(true);
            $table->string('ethnic')->nullable(); //
            $table->string('blood_type')->nullable();
            $table->string('candidate_from')->nullable(); //
            $table->string('applied_position')->nullable(); //
            $table->string('recommended_position')->nullable(); //
            $table->string('marital_status')->nullable(); //

            $table->string('file_cv')->nullable(); //
            $table->string('file_kk')->nullable(); //
            $table->string('file_ktp')->nullable(); //
            $table->string('file_skck')->nullable(); //

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
