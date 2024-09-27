<?php

use App\Models\WorkUnit\Directorate;
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
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(Directorate::class)->nullable()->constrained()->onDelete('cascade');
            $table->string('code')->nullable();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('divisions');
    }
};
