<?php

require_once __DIR__ . '/../app/Polyfills/Locale.php';

// Render supplies a PostgreSQL connection URL and the public site URL.
// Keep the existing local MySQL configuration when these are absent.
$renderUrl = getenv('RENDER_EXTERNAL_URL');
if ($renderUrl !== false && $renderUrl !== '') {
    $_ENV['app_baseURL'] = $_SERVER['app_baseURL'] = rtrim($renderUrl, '/') . '/';
    $_ENV['app_indexPage'] = $_SERVER['app_indexPage'] = '';
}

$databaseUrl = getenv('DATABASE_URL');
if ($databaseUrl !== false && $databaseUrl !== '') {
    $database = parse_url($databaseUrl);
    if ($database === false || ! isset($database['host'], $database['user'], $database['path'])) {
        throw new RuntimeException('Invalid DATABASE_URL configuration.');
    }

    $settings = [
        'DBDriver' => 'Postgre',
        'hostname' => $database['host'],
        'port'     => (string) ($database['port'] ?? 5432),
        'database' => ltrim($database['path'], '/'),
        'username' => rawurldecode($database['user']),
        'password' => rawurldecode($database['pass'] ?? ''),
    ];

    foreach ($settings as $key => $value) {
        $_ENV['database_default_' . $key] = $_SERVER['database_default_' . $key] = $value;
    }
}

/*
 *---------------------------------------------------------------
 * CHECK PHP VERSION
 *---------------------------------------------------------------
 */

$minPhpVersion = '8.1'; // If you update this, don't forget to update `spark`.
if (version_compare(PHP_VERSION, $minPhpVersion, '<')) {
    $message = sprintf(
        'Your PHP version must be %s or higher to run CodeIgniter. Current version: %s',
        $minPhpVersion,
        PHP_VERSION
    );

    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    echo $message;

    exit(1);
}

/*
 *---------------------------------------------------------------
 * SET THE CURRENT DIRECTORY
 *---------------------------------------------------------------
 */

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Ensure the current directory is pointing to the front controller's directory
if (getcwd() . DIRECTORY_SEPARATOR !== FCPATH) {
    chdir(FCPATH);
}

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 * This process sets up the path constants, loads and registers
 * our autoloader, along with Composer's, loads our constants
 * and fires up an environment-specific bootstrapping.
 */

// LOAD OUR PATHS CONFIG FILE
// This is the line that might need to be changed, depending on your folder structure.
require FCPATH . '../app/Config/Paths.php';
// ^^^ Change this line if you move your application folder

$paths = new Config\Paths();

// LOAD THE FRAMEWORK BOOTSTRAP FILE
require $paths->systemDirectory . '/Boot.php';

exit(CodeIgniter\Boot::bootWeb($paths));
