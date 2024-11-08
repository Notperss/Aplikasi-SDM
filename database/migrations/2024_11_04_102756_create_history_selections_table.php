<?php

use App\Models\Recruitment\Selection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('history_selections', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Selection::class)->constrained()->onDelete('cascade');
            $table->date('date');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('history_selections');
    }
};
