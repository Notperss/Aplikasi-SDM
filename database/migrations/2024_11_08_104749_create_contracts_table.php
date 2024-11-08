<?php

use App\Models\Employee\Employee;
use App\Models\ManagementAccess\Company;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Employee::class)->constrained()->onDelete('cascade');
            $table->string('nik_employee');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('duration');
            $table->string('contract_number');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('contracts');
    }
};
