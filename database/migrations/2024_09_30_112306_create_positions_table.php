<?php

use App\Models\Position\Level;
use Illuminate\Support\Facades\Schema;
use App\Models\ManagementAccess\Company;
use App\Models\WorkUnit\Department;
use App\Models\WorkUnit\Directorate;
use App\Models\WorkUnit\Division;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->nullable()->constrained()->onDelete('cascade');
            // $table->foreignIdFor(Employee::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(Directorate::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(Division::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(Department::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(Level::class)->nullable()->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('positions');
    }
};
