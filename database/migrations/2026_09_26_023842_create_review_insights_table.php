<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('review_insights', function (Blueprint $table) {
            $table->id();

            $table->foreignId('review_id')
                ->constrained('reviews')
                ->cascadeOnDelete();

            $table->string('topic');

            $table->enum('sentiment', [
                'positive',
                'negative',
                'neutral',
            ]);

            $table->decimal('confidence', 5, 2)->nullable();

            $table->timestamps();

            $table->unique([
                'review_id',
                'topic',
            ]);

            $table->index('topic');
            $table->index('sentiment');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('review_insights');
    }
};
