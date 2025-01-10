<?php

use App\Models\WorkUnit\Division;
use Illuminate\Support\Facades\Schema;
use App\Models\ManagementAccess\Company;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('folder_divisions', function (Blueprint $table) {
            $table->id();
            $table->nestedSet(); //nestedset by lazychaser
            $table->foreignIdFor(Company::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Division::class)->constrained()->onDelete('cascade');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->boolean('is_lock')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('folder_divisions');
    }
};
