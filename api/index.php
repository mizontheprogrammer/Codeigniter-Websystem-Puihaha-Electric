<?php

declare(strict_types=1);

$root = dirname(__DIR__);

// Vercel Functions are read-only except for /tmp. CodeIgniter needs writable
// session, cache, log, and debug directories at runtime.
$writable = '/tmp/puihaha-writable';
foreach (['cache', 'debugbar', 'logs', 'session', 'uploads'] as $directory) {
    if (! is_dir($writable . '/' . $directory)) {
        mkdir($writable . '/' . $directory, 0775, true);
    }
}

$_SERVER['CI_ENVIRONMENT'] = $_ENV['CI_ENVIRONMENT'] = 'production';
$_SERVER['app_baseURL'] = $_ENV['app_baseURL'] = 'https://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . '/';
$_SERVER['app_indexPage'] = $_ENV['app_indexPage'] = '';
$_SERVER['session_savePath'] = $_ENV['session_savePath'] = $writable . '/session';

$databaseVariables = [
    'DB_HOST'     => 'database_default_hostname',
    'DB_PORT'     => 'database_default_port',
    'DB_NAME'     => 'database_default_database',
    'DB_USER'     => 'database_default_username',
    'DB_PASSWORD' => 'database_default_password',
];

foreach ($databaseVariables as $source => $target) {
    $value = getenv($source);
    if ($value !== false) {
        $_SERVER[$target] = $_ENV[$target] = $value;
    }
}

if (getenv('DB_SSL') === 'true') {
    $_SERVER['database_default_encrypt'] = $_ENV['database_default_encrypt'] = 'true';
}

require_once $root . '/app/Polyfills/Locale.php';

define('FCPATH', $root . '/public/');
chdir(FCPATH);

require FCPATH . '../app/Config/Paths.php';

$paths = new Config\Paths();
$paths->writableDirectory = $writable;

require $paths->systemDirectory . '/Boot.php';

exit(CodeIgniter\Boot::bootWeb($paths));
