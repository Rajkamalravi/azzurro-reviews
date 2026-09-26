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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('property_id')
                ->constrained('properties')
                ->cascadeOnDelete();

            // Used to prevent importing the same review more than once.
            $table->string('fingerprint', 64);

            // Booking.com review ID if we can reliably extract one.
            $table->string('external_id')->nullable();

            // Booking.com rating, e.g. 8.5
            $table->decimal('rating', 3, 1)->nullable();

            $table->date('review_date')->nullable();

            $table->text('positive_text')->nullable();
            $table->text('negative_text')->nullable();

            $table->string('reviewer_name')->nullable();
            $table->string('reviewer_country')->nullable();

            $table->string('room_type')->nullable();
            $table->string('travel_type')->nullable();

            // Original Booking.com page.
            $table->text('source_url');

            // When our scraper collected the review.
            $table->timestamp('scraped_at')->nullable();

            $table->timestamps();

            // Same review on the same property should never be inserted twice.
            $table->unique(
                ['property_id', 'fingerprint'],
                'reviews_property_fingerprint_unique'
            );

            // Useful for incremental imports if Booking.com exposes an ID.
            $table->index(
                ['property_id', 'external_id'],
                'reviews_property_external_id_index'
            );

            $table->index('review_date');
            $table->index('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
