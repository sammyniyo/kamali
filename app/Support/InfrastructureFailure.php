<?php

namespace App\Support;

use Illuminate\Database\LostConnectionException;
use Illuminate\Database\QueryException;
use PDOException;
use Throwable;

class InfrastructureFailure
{
    /**
     * Whether the exception indicates the app cannot reach storage, DB, or similar
     * (so we should show a minimal page instead of Ignition / stack traces).
     */
    public static function recognizes(Throwable $e): bool
    {
        if ($e instanceof LostConnectionException) {
            return true;
        }

        if ($e instanceof QueryException) {
            foreach (self::collectMessages($e) as $message) {
                if (self::messageIndicatesInfrastructureFailure($message)) {
                    return true;
                }
            }

            return false;
        }

        if ($e instanceof PDOException) {
            return self::messageIndicatesInfrastructureFailure($e->getMessage());
        }

        return false;
    }

    /**
     * @return list<string>
     */
    private static function collectMessages(Throwable $e): array
    {
        $out = [$e->getMessage()];
        $prev = $e->getPrevious();
        while ($prev instanceof Throwable) {
            $out[] = $prev->getMessage();
            $prev = $prev->getPrevious();
        }

        return $out;
    }

    private static function messageIndicatesInfrastructureFailure(string $message): bool
    {
        $m = strtolower($message);

        if ($m === '') {
            return false;
        }

        // MySQL / PDO client cannot reach server
        if (str_contains($m, 'network is unreachable')) {
            return true;
        }
        if (str_contains($m, 'connection refused')) {
            return true;
        }
        if (str_contains($m, 'connection timed out')) {
            return true;
        }
        if (str_contains($m, 'no route to host')) {
            return true;
        }
        if (str_contains($m, 'getaddrinfo') && str_contains($m, 'failed')) {
            return true;
        }
        if (str_contains($m, 'could not translate host name')) {
            return true;
        }
        if (str_contains($m, 'php_network_getaddresses')) {
            return true;
        }
        if (str_contains($m, 'sqlstate[hy000] [2002]')) {
            return true;
        }
        if (str_contains($m, 'sqlstate[hy000] [2006]')) {
            return true;
        }
        if (str_contains($m, 'server has gone away')) {
            return true;
        }
        if (str_contains($m, 'lost connection to mysql')) {
            return true;
        }
        if (str_contains($m, 'unknown database')) {
            return true;
        }
        if (str_contains($m, 'access denied for user')) {
            return true;
        }
        if (str_contains($m, 'could not find driver')) {
            return true;
        }

        // SQLite
        if (str_contains($m, 'unable to open database file')) {
            return true;
        }
        if (str_contains($m, 'database disk image is malformed')) {
            return true;
        }

        return false;
    }
}
