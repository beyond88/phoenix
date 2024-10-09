<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePostCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terms', function (Blueprint $table) {
            $table->bigIncrements('term_id');
            $table->string('name', 200)->default('');
            $table->string('slug', 200)->default('');
        });

        // Add indexes with length specification using raw SQL
        DB::statement('ALTER TABLE terms ADD INDEX slug_index (slug(191))');
        DB::statement('ALTER TABLE terms ADD INDEX name_index (name(191))');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('terms');
    }
}
