<?php

use App\Models\ManagementAccess\Company;
use App\Models\Position\Position;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('selections', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(Position::class)->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('pic_selection')->nullable();
            $table->string('interviewer')->nullable();
            $table->date('date_selection');
            $table->date('start_selection');
            $table->date('end_selection')->nullable();
            $table->text('description')->nullable();
            $table->string('file_selection')->nullable();
            $table->boolean('is_finished')->default(false)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('selections');
    }
};
