<?php

use App\Models\Position\Level;
use App\Models\Position\Allowance;
use Illuminate\Support\Facades\Schema;
use App\Models\ManagementAccess\Company;
use App\Models\Position\Position;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('position_allowances', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(Position::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Allowance::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('position_allowances');
    }
};
