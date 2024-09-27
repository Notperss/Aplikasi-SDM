<?php

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
        Schema::create('allowances', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->nullable()->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('type')->nullable();
            $table->string('amount')->nullable();
            $table->date('efective_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('allowances');
    }
};
