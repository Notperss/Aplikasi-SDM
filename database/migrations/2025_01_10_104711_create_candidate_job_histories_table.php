<?php

use App\Models\Recruitment\Candidate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('candidate_job_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Candidate::class)->constrained()->onDelete('cascade');
            $table->string('company_name');
            $table->string('company_type')->nullable();
            $table->string('city')->nullable();
            $table->string('period')->nullable();
            // $table->year('year_to')->nullable()->nullable();
            $table->string('position')->nullable();
            $table->string('salary')->nullable();
            $table->text('reason')->nullable();
            $table->text('job_description')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_job_histories');
    }
};
