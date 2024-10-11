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
        Schema::create('candidate_language_proficiencies', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Candidate::class)->constrained()->onDelete('cascade');
            $table->string('language');
            $table->string('speaking');
            $table->string('writing');
            $table->string('listening');
            $table->string('reading');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('candidate_language_proficiencies');
    }
};
