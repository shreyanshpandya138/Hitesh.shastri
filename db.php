<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

function review_db(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $host = getenv('DB_HOST') ?: '127.0.0.1';
    $port = getenv('DB_PORT') ?: '3306';
    $database = getenv('DB_NAME') ?: 'portfolio_reviews';
    $username = getenv('DB_USER') ?: 'root';
    $password = getenv('DB_PASSWORD') ?: '';

    $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $host, $port, $database);

    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    return $pdo;
}

function review_response(array $payload, int $statusCode = 200): void
{
    http_response_code($statusCode);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

function normalize_review(array $review): array
{
    $rating = (int) ($review['rating'] ?? 0);

    return [
        'id' => isset($review['id']) ? (int) $review['id'] : null,
        'name' => (string) ($review['name'] ?? ''),
        'rating' => $rating,
        'emoji' => review_emoji($rating),
        'description' => (string) ($review['description'] ?? ''),
        'created_at' => (string) ($review['created_at'] ?? ''),
    ];
}

function review_emoji(int $rating): string
{
    return match ($rating) {
        1 => '😞',
        2 => '😕',
        3 => '🙂',
        4 => '😊',
        5 => '🤩',
        default => '🙂',
    };
}
