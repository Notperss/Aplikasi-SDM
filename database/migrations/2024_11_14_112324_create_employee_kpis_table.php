<?php

use App\Models\Employee\Employee;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('employee_kpis', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Employee::class)->nullable()->constrained()->onDelete('cascade');
            $table->string('nik_employee')->nullable();
            $table->date('kpi_date');
            $table->string('grade');
            $table->boolean('contract_recommendation')->nullable()->default(null);
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('employee_kpis');
    }
};
