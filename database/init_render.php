<?php

declare(strict_types=1);

$databaseUrl = getenv('DATABASE_URL');
if ($databaseUrl === false || $databaseUrl === '') {
    fwrite(STDERR, "DATABASE_URL is required on Render.\n");
    exit(1);
}

$parts = parse_url($databaseUrl);
if ($parts === false || ! isset($parts['host'], $parts['user'], $parts['path'])) {
    fwrite(STDERR, "DATABASE_URL is invalid.\n");
    exit(1);
}

$db = false;
for ($attempt = 0; $attempt < 30; $attempt++) {
    $db = @pg_connect($databaseUrl);
    if ($db !== false) {
        break;
    }
    sleep(2);
}
if ($db === false) {
    fwrite(STDERR, "Could not connect to Render Postgres.\n");
    exit(1);
}

function runQuery(PgSql\Connection $db, string $sql): PgSql\Result
{
    $result = pg_query($db, $sql);
    if ($result === false) {
        throw new RuntimeException(pg_last_error($db));
    }

    return $result;
}

try {
    runQuery($db, 'BEGIN');
    runQuery($db, 'SELECT pg_advisory_xact_lock(49281012)');
    runQuery($db, file_get_contents(__DIR__ . '/render_postgres_schema.sql'));

    $seeded = pg_fetch_result(runQuery(
        $db,
        "SELECT COUNT(*) FROM seed_imports WHERE name = 'professor_customer_accounts_v1'"
    ), 0, 0);

    if ((int) $seeded === 0) {
        $dump = file_get_contents(__DIR__ . '/customer_accounts_seed.sql');
        if (! preg_match('/INSERT INTO `customer_accounts`.*?;/s', $dump, $matches)) {
            throw new RuntimeException('Customer account seed data is missing.');
        }

        $insert = str_replace(['`', '\\r\\n'], ['"', ' '], $matches[0]);
        $insert = rtrim($insert, "; \t\r\n") . ' ON CONFLICT (id) DO NOTHING';
        runQuery($db, $insert);
        runQuery($db, "INSERT INTO seed_imports (name) VALUES ('professor_customer_accounts_v1')");
    }

    $initialData = getenv('RENDER_INITIAL_DATA_B64');
    if ($initialData !== false && $initialData !== '') {
        $imported = pg_fetch_result(runQuery(
            $db,
            "SELECT COUNT(*) FROM seed_imports WHERE name = 'local_account_data_v1'"
        ), 0, 0);

        if ((int) $imported === 0) {
            $json = base64_decode($initialData, true);
            $rows = $json === false ? null : json_decode($json, true);
            if (! is_array($rows)) {
                throw new RuntimeException('Initial account data is invalid.');
            }

            $tables = [
                'user_accounts' => ['id', 'username', 'password', 'full_name', 'created_at', 'updated_at'],
                'users' => ['id', 'first_name', 'last_name', 'email', 'phone', 'address', 'city', 'state', 'zip_code', 'password', 'user_type', 'is_active', 'email_verified', 'created_at', 'updated_at'],
                'contact_messages' => ['id', 'name', 'email', 'phone', 'service_type', 'message', 'created_at', 'updated_at'],
            ];

            foreach ($tables as $table => $columns) {
                foreach ($rows[$table] ?? [] as $row) {
                    $values = array_map(static fn (string $column) => $row[$column] ?? null, $columns);
                    $placeholders = array_map(static fn (int $index) => '$' . ($index + 1), array_keys($columns));
                    $query = 'INSERT INTO ' . $table . ' (' . implode(', ', $columns) . ') VALUES ('
                        . implode(', ', $placeholders) . ') ON CONFLICT (id) DO NOTHING';
                    if (pg_query_params($db, $query, $values) === false) {
                        throw new RuntimeException(pg_last_error($db));
                    }
                }

                runQuery($db, "SELECT setval(pg_get_serial_sequence('" . $table . "', 'id'), GREATEST((SELECT COALESCE(MAX(id), 1) FROM " . $table . "), 1), true)");
            }

            runQuery($db, "INSERT INTO seed_imports (name) VALUES ('local_account_data_v1')");
        }
    }

    runQuery($db, "SELECT setval(pg_get_serial_sequence('customer_accounts', 'id'), GREATEST((SELECT COALESCE(MAX(id), 1) FROM customer_accounts), 1), true)");
    runQuery($db, 'COMMIT');
    fwrite(STDOUT, "Database is ready.\n");
} catch (Throwable $error) {
    pg_query($db, 'ROLLBACK');
    fwrite(STDERR, 'Database setup failed: ' . $error->getMessage() . "\n");
    exit(1);
}
