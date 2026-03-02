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
        Schema::create('knowledge_posts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('resident_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');


            $table->string('knowledge_title');
            $table->text('knowledge_content');

            $table->string('status')->default('draft');
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knowledge_posts');
    }
};
