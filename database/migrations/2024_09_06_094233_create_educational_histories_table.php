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
        Schema::create('educational_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Candidate::class)->constrained()->onDelete('cascade');
            $table->string('school_level');
            $table->string('school_name');
            $table->string('study')->nullable();
            $table->year('year_from');
            $table->year('year_to')->nullable();
            $table->string('gpa')->nullable();
            $table->string('graduate')->nullable();
            $table->string('file_ijazah')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('educational_histories');
    }
};
