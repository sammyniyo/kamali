<?php

namespace App\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Throwable;

class SafeQuery
{
    public static function hasTable(string $table): bool
    {
        try {
            return Schema::hasTable($table);
        } catch (Throwable) {
            return false;
        }
    }

    /**
     * @template T
     *
     * @param  callable(): T  $callback
     * @param  T|null  $default
     * @return T
     */
    public static function run(string $table, callable $callback, mixed $default = null): mixed
    {
        if (! self::hasTable($table)) {
            return $default ?? collect();
        }

        try {
            return $callback();
        } catch (Throwable $e) {
            Log::warning("SafeQuery failed on [{$table}]: ".$e->getMessage());

            return $default ?? collect();
        }
    }

    /**
     * @return Collection<int, mixed>
     */
    public static function collection(string $table, callable $callback): Collection
    {
        $result = self::run($table, $callback, collect());

        return $result instanceof Collection ? $result : collect($result);
    }
}
