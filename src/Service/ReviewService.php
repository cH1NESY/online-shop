<?php

namespace Service;


use Model\Review;

class ReviewService
{
    public function getAvgRating(array $reviews = []):float|int
    {
        $sum = 0;
        $count = 0;
        foreach ($reviews as $review) {
            {
                $sum += $review->getRating();
                $count++;
            }
        }
        $avg = $sum / $count;

        return $avg;
    }
}