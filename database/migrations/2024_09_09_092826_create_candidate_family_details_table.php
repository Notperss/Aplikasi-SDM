<?php

use App\Models\Recruitment\Candidate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('candidate_family_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Candidate::class)->constrained()->onDelete('cascade');
            $table->string('relation');
            $table->enum('gender', ['LAKI-LAKI', 'PEREMPUAN']);
            $table->string('name');
            $table->date('dob_family');
            $table->string('education');
            $table->string('job')->nullable();
            $table->string('phone_number')->nullable();
            $table->text('address');
            $table->boolean('is_in_kk')->default(false);
            // $table->boolean('is_emergency_contact')->default(false);
            $table->boolean('is_bpjs')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('candidate_family_details');
    }
};
