<?php

namespace App\Console\Commands;

use App\Models\Review;
use App\Services\ReviewClassifier;
use Illuminate\Console\Command;

class ClassifyReviews extends Command
{
    protected $signature = 'reviews:classify';

    protected $description = 'Classify reviews into operational topics and sentiment';

    public function handle(ReviewClassifier $classifier): int
    {
        $count = 0;

        Review::query()
            ->chunkById(100, function ($reviews) use ($classifier, &$count) {
                foreach ($reviews as $review) {
                    $classifier->classify($review);
                    $count++;
                }
            });

        $this->info("Classified {$count} reviews.");

        return self::SUCCESS;
    }
}
