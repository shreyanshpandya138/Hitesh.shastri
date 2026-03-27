<?php

declare(strict_types=1);

require __DIR__ . '/db.php';

try {
    $statement = review_db()->query(
        'SELECT id, name, rating, description, created_at
         FROM reviews
         ORDER BY created_at DESC, id DESC'
    );

    $reviews = array_map(
        static fn (array $review): array => normalize_review($review),
        $statement->fetchAll()
    );

    review_response([
        'success' => true,
        'reviews' => $reviews,
    ]);
} catch (Throwable $exception) {
    review_response([
        'success' => false,
        'message' => 'Failed to fetch reviews.',
    ], 500);
}
