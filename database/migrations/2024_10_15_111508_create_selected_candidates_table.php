<?php

use App\Models\Recruitment\Candidate;
use App\Models\Recruitment\Selection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('selected_candidates', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Candidate::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Selection::class)->constrained()->onDelete('cascade');
            $table->string('file_selected_candidate')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_approve')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('selected_candidates');
    }
};
