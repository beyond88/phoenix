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
            $table->bigIncrements('object_id')->unsigned();
            $table->bigInteger('term_taxonomy_id')->unsigned();
            $table->integer('term_order')->default(0);
            $table->index('term_taxonomy_id');
            $table->timestamps();
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
