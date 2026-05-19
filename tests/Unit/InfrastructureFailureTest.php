<?php

namespace Tests\Unit;

use App\Support\InfrastructureFailure;
use Illuminate\Database\LostConnectionException;
use Illuminate\Database\QueryException;
use PDOException;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class InfrastructureFailureTest extends TestCase
{
    public function test_recognizes_lost_connection_exception(): void
    {
        $this->assertTrue(InfrastructureFailure::recognizes(new LostConnectionException('gone')));
    }

    public function test_recognizes_query_exception_with_network_unreachable(): void
    {
        $pdo = new PDOException('SQLSTATE[HY000] [2002] Network is unreachable', 2002);
        $e = new QueryException('mysql', 'select 1', [], $pdo);

        $this->assertTrue(InfrastructureFailure::recognizes($e));
    }

    public function test_recognizes_plain_pdo_connection_refused(): void
    {
        $e = new PDOException('SQLSTATE[HY000] [2002] Connection refused');

        $this->assertTrue(InfrastructureFailure::recognizes($e));
    }

    public function test_does_not_mask_query_exception_syntax_error(): void
    {
        $pdo = new PDOException('SQLSTATE[42000]: Syntax error or access violation: 1064', 42000);
        $e = new QueryException('mysql', 'select froooom', [], $pdo);

        $this->assertFalse(InfrastructureFailure::recognizes($e));
    }

    #[DataProvider('nonDatabaseThrowables')]
    public function test_ignores_non_database_throwables(\Throwable $e): void
    {
        $this->assertFalse(InfrastructureFailure::recognizes($e));
    }

    /**
     * @return iterable<string, array{\Throwable}>
     */
    public static function nonDatabaseThrowables(): iterable
    {
        yield 'runtime' => [new \RuntimeException('Connection refused in app logic')];

        yield 'invalid_argument' => [new \InvalidArgumentException('Network is unreachable from validator')];
    }
}
