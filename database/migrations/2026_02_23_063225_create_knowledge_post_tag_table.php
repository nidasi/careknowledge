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
        Schema::create('knowledge_post_tag', function (Blueprint $table) {
            $table->id();

            $table->foreignId('knowledge_post_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('tag_id')
                ->constrained()
                ->onDelete('cascade');

                //複合主キー
                $table->primary(['knowledge_post_id','tag_id'])


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knowledge_post_tag');
    }
};
