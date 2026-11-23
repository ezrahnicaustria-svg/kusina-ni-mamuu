<?php

namespace App\Support;

class JsonStore
{
    private static function path(string $file): string
    {
        $cleanName = str_ends_with($file, '.json') ? $file : $file . '.json';
        return storage_path('app/private/' . basename($cleanName));
    }

    public static function read(string $file): array
    {
        $path = self::path($file);

        if (!file_exists($path)) {
            return [];
        }

        $content = file_get_contents($path);
        if ($content === false || trim($content) === '') {
            return [];
        }

        $decoded = json_decode($content, true);
        return is_array($decoded) ? $decoded : [];
    }

    public static function write(string $file, array $data): bool
    {
        $path = self::path($file);
        $dir = dirname($path);

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $json = json_encode(array_values($data), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        if ($json === false) {
            return false;
        }

        return file_put_contents($path, $json . PHP_EOL, LOCK_EX) !== false;
    }
}