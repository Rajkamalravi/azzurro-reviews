<?php

namespace App\Services;

use App\Models\Review;
use App\Models\ReviewInsight;

class ReviewClassifier
{
    public function classify(Review $review): void
    {
        // Remove previous classifications so we can safely re-run
        // the classifier when the rules change.
        $review->insights()->delete();

        // Positive part of the review
        if (!empty($review->positive_text)) {
            $this->classifyText(
                $review,
                $review->positive_text,
                'positive'
            );
        }

        // Negative part of the review
        if (!empty($review->negative_text)) {
            $this->classifyText(
                $review,
                $review->negative_text,
                'negative'
            );
        }
    }

    private function classifyText(
        Review $review,
        string $text,
        string $sentiment
    ): void {
        $text = strtolower($text);

        $topics = config('review_topics');

        foreach ($topics as $topic => $keywords) {
            $matches = $this->findMatches($text, $keywords);

            if (empty($matches)) {
                continue;
            }

            ReviewInsight::updateOrCreate(
                [
                    'review_id' => $review->id,
                    'topic' => $topic,
                ],
                [
                    'sentiment' => $sentiment,
                    'confidence' => $this->calculateConfidence(
                        $matches,
                        $keywords
                    ),
                ]
            );
        }
    }

    private function findMatches(
        string $text,
        array $keywords
    ): array {
        $matches = [];

        foreach ($keywords as $keyword) {
            if (str_contains($text, strtolower($keyword))) {
                $matches[] = $keyword;
            }
        }

        return $matches;
    }

    private function calculateConfidence(
        array $matches,
        array $keywords
    ): float {
        if (empty($keywords)) {
            return 0;
        }

        return min(
            100,
            round((count($matches) / count($keywords)) * 100, 2)
        );
    }
}
