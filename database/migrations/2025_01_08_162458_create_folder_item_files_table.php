<?php

use App\Models\WorkUnit\Division;
use Illuminate\Support\Facades\Schema;
use App\Models\ManagementAccess\Company;
use Illuminate\Database\Schema\Blueprint;
use App\Models\FolderDivision\FolderDivision;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('folder_item_files', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(FolderDivision::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Company::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Division::class)->constrained()->onDelete('cascade');
            $table->string('number')->nullable();
            $table->date('date')->nullable();
            $table->string('file')->nullable();
            $table->string('notification')->nullable();
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
        Schema::dropIfExists('folder_item_files');
    }
};
