<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('e_papers', function (Blueprint $table) {
            $table->id();
            $table->date('release_date');
            $table->string('title', 150)->default('');
            $table->string('description', 255)->default('');
            $table->integer('page_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('e_papers');
    }
};
