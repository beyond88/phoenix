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
        Schema::create('term_relationships', function (Blueprint $table) {
            $table->bigInteger('object_id', true, true)->unsigned()->default(0);
            $table->bigInteger('term_taxonomy_id')->unsigned()->default(0);
            $table->integer('term_order')->default(0);
            
            // Primary key
            $table->primary(['object_id', 'term_taxonomy_id']);
            
            // Index for term_taxonomy_id
            $table->index('term_taxonomy_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('term_relationships');
    }
};
