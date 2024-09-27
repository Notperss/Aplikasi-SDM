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
        Schema::create('employment_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Candidate::class)->constrained()->onDelete('cascade');
            $table->string('company_name');
            $table->string('company_type')->nullable();
            $table->string('direct_supervisor')->nullable();
            $table->year('year_from');
            $table->year('year_to')->nullable();
            $table->string('position');
            $table->string('salary');
            $table->text('reason');
            $table->text('job_description')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('employment_histories');
    }
};
