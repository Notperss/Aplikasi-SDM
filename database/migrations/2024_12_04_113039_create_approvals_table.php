<?php

use App\Models\Employee\PersonalData\EmployeeCareer;
use App\Models\Recruitment\SelectedCandidate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(EmployeeCareer::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(SelectedCandidate::class)->nullable()->constrained()->cascadeOnDelete();
            $table->boolean('is_approve')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('approvals');
    }
};
