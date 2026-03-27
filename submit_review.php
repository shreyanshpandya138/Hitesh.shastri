<?php

declare(strict_types=1);

require __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    review_response([
        'success' => false,
        'message' => 'Method not allowed.',
    ], 405);
}

$rawBody = file_get_contents('php://input');
$data = json_decode($rawBody ?: '[]', true);

if (!is_array($data)) {
    review_response([
        'success' => false,
        'message' => 'Invalid request body.',
    ], 400);
}

$name = trim((string) ($data['name'] ?? ''));
$description = trim((string) ($data['description'] ?? ''));
$rating = (int) ($data['rating'] ?? 0);

if ($name === '' || $description === '' || $rating < 1 || $rating > 5) {
    review_response([
        'success' => false,
        'message' => 'Name, description, and a 1 to 5 star rating are required.',
    ], 422);
}

try {
    $pdo = review_db();

    $duplicateCheck = $pdo->prepare(
        'SELECT id, name, rating, description, created_at
         FROM reviews
         WHERE name = :name
           AND rating = :rating
           AND description = :description
           AND created_at >= (NOW() - INTERVAL 2 MINUTE)
         ORDER BY id DESC
         LIMIT 1'
    );
    $duplicateCheck->execute([
        'name' => $name,
        'rating' => $rating,
        'description' => $description,
    ]);

    $existingReview = $duplicateCheck->fetch();

    if ($existingReview) {
        review_response([
            'success' => true,
            'message' => 'Review already exists.',
            'review' => normalize_review($existingReview),
        ]);
    }

    $insert = $pdo->prepare(
        'INSERT INTO reviews (name, rating, description)
         VALUES (:name, :rating, :description)'
    );
    $insert->execute([
        'name' => $name,
        'rating' => $rating,
        'description' => $description,
    ]);

    $select = $pdo->prepare(
        'SELECT id, name, rating, description, created_at
         FROM reviews
         WHERE id = :id
         LIMIT 1'
    );
    $select->execute([
        'id' => (int) $pdo->lastInsertId(),
    ]);

    $review = $select->fetch();

    review_response([
        'success' => true,
        'message' => 'Review submitted successfully.',
        'review' => normalize_review($review ?: [
            'name' => $name,
            'rating' => $rating,
            'description' => $description,
        ]),
    ], 201);
} catch (Throwable $exception) {
    review_response([
        'success' => false,
        'message' => 'Failed to save review.',
    ], 500);
}
