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
        Schema::table('articles', function (Blueprint $table) {
            // Index untuk sorting by created_at (latest())
            $table->index('created_at', 'articles_created_at_index');

            // Index untuk published_at (filtering artikel published)
            $table->index('published_at', 'articles_published_at_index');

            // Index untuk author (jika sering filter by author)
            $table->index('author', 'articles_author_index');

            // Composite index untuk query yang sering (created_by + updated_by)
            $table->index(['created_by', 'updated_by'], 'articles_user_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropIndex('articles_created_at_index');
            $table->dropIndex('articles_published_at_index');
            $table->dropIndex('articles_author_index');
            $table->dropIndex('articles_user_index');
        });
    }
};
