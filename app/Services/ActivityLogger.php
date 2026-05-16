<?php

namespace App\Services;

class ActivityLogger
{
    public function log(string $event, array $payload = []): void
    {
        if (! class_exists(\MongoDB\Client::class)) {
            logger()->info("activity:{$event}", $payload);
            return;
        }

        $client = new \MongoDB\Client(config('database.connections.mongodb.dsn'));
        $client
            ->selectDatabase(config('database.connections.mongodb.database'))
            ->selectCollection('activity_logs')
            ->insertOne(['event' => $event, 'payload' => $payload, 'created_at' => now()->toIso8601String()]);
    }
}
