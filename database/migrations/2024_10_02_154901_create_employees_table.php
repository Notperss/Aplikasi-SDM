<?php

use App\Models\Employee\EmployeeCategory;
use Illuminate\Support\Facades\Schema;
use App\Models\ManagementAccess\Company;
use App\Models\Position\Position;
use App\Models\Recruitment\Candidate;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    { // status hubungan kerja 
        // status karyawan
        //nomor BPJS
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(Candidate::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(Position::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(EmployeeCategory::class)->nullable()->constrained()->onDelete('cascade');
            $table->string('name'); //
            $table->string('nik'); ////
            $table->date('dob'); //
            $table->string('pob'); //
            $table->string('email'); //
            $table->string('phone_number1')->nullable(); //
            $table->string('phone_number2')->nullable(); ////
            $table->string('photo')->nullable(); //
            $table->text('ktp_address'); //
            $table->integer('zipcode_ktp'); ////
            $table->text('current_address'); //
            $table->string('npwp_number')->nullable(); ////
            $table->string('ktp_number')->nullable();//
            $table->string('kk_number')->nullable();//
            $table->string('bpjs_kesehatan_number')->nullable();////
            $table->string('bpjs_naker_number')->nullable();////
            $table->string('religion')->nullable();//
            $table->string('nationality')->nullable();//

            $table->string('employee_status')->nullable();////
            $table->string('work_status')->nullable();////
            $table->string('work_relationship')->nullable(); ////

            $table->enum('gender', ['LAKI-LAKI', 'PEREMPUAN']); //
            $table->date('date_joining')->nullable();////
            $table->date('date_leaving')->nullable();////

            $table->boolean('is_verified')->default(false);////

            $table->string('ethnic')->nullable(); //
            $table->string('blood_type')->nullable();//
            $table->string('candidate_from')->nullable(); //

            $table->string('marital_status')->nullable(); //

            $table->string('paspor_number')->nullable(); //

            $table->string('file_cv')->nullable(); //
            $table->string('file_kk')->nullable(); //
            $table->string('file_ijazah')->nullable(); //
            $table->string('file_ktp')->nullable(); //
            $table->string('file_skck')->nullable(); //
            $table->string('file_sertifikat')->nullable(); //
            $table->string('file_vaksin')->nullable(); //
            $table->string('file_surat_sehat')->nullable(); //

            $table->string('longitude_ktp')->nullable(); //
            $table->string('longitude_domisili')->nullable();//
            $table->string('latitude_ktp')->nullable();//
            $table->string('latitude_domisili')->nullable();//

            $table->string('sim_a')->nullable();//
            $table->string('expired_sim_a')->nullable();//
            $table->string('file_sim_a')->nullable();//

            $table->string('sim_b')->nullable();//
            $table->string('expired_sim_b')->nullable();//
            $table->string('file_sim_b')->nullable();//

            $table->string('sim_c')->nullable();//
            $table->string('expired_sim_c')->nullable();//
            $table->string('file_sim_c')->nullable();//

            $table->string('temporary')->nullable(); ////
            $table->string('contract')->nullable();////

            $table->string('add1')->nullable(); ////
            $table->string('add2')->nullable();////
            $table->string('add3')->nullable();////
            $table->string('add4')->nullable();////
            $table->string('add5')->nullable();////

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('employees');
    }
};
