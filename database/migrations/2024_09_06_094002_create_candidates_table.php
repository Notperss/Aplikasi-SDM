<?php

use Illuminate\Support\Facades\Schema;
use App\Models\ManagementAccess\Company;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->nullable()->constrained()->onDelete('restrict');
            $table->string('name');
            $table->date('dob');
            $table->string('pob');
            $table->string('email');
            $table->string('phone_number');
            $table->string('photo')->nullable();
            $table->text('ktp_address');
            $table->text('current_address');
            // $table->string('npwp_number');
            $table->string('ktp_number')->nullable();
            $table->string('kk_number')->nullable();
            $table->string('religion')->nullable();
            $table->string('nationality')->nullable();

            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->boolean('glasses')->nullable();


            $table->enum('gender', ['LAKI-LAKI', 'PEREMPUAN']);
            $table->date('date_applied')->nullable();

            $table->text('tag')->nullable();

            $table->boolean('is_selection')->default(false);
            $table->boolean('is_hire')->default(false);
            $table->string('ethnic')->nullable(); //
            $table->string('blood_type')->nullable();
            $table->string('candidate_from')->nullable(); //
            $table->string('applied_position')->nullable(); //
            $table->string('recommended_position')->nullable(); //
            $table->string('marital_status')->nullable(); //

            $table->string('paspor_number')->nullable(); //
            $table->string('last_educational')->nullable(); //
            $table->string('study')->nullable(); //
            $table->string('reference')->nullable(); //
            $table->string('disability')->nullable(); //

            $table->string('file_cv')->nullable(); //
            $table->string('file_kk')->nullable(); //
            $table->string('file_ijazah')->nullable(); //
            $table->string('file_ktp')->nullable(); //
            $table->string('file_skck')->nullable(); //
            $table->string('file_sertifikat')->nullable(); //
            $table->string('file_vaksin')->nullable(); //
            $table->string('file_surat_sehat')->nullable(); //

            $table->string('longitude_ktp')->nullable();
            $table->string('longitude_domisili')->nullable();
            $table->string('latitude_ktp')->nullable();
            $table->string('latitude_domisili')->nullable();

            $table->string('sim_a')->nullable();
            $table->string('expired_sim_a')->nullable();
            $table->string('file_sim_a')->nullable();

            $table->string('sim_b')->nullable();
            $table->string('expired_sim_b')->nullable();
            $table->string('file_sim_b')->nullable();

            $table->string('sim_c')->nullable();
            $table->string('expired_sim_c')->nullable();
            $table->string('file_sim_c')->nullable();

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
