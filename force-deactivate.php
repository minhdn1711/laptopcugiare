<?php
/**
 * Emergency Plugin Deactivator (Database Level)
 */
$config_file = 'wp-config.php';
if (!file_exists($config_file)) {
    die("wp-config.php not found.");
}

// Extract DB info from wp-config.php
$content = file_get_contents($config_file);
preg_match("/define\(\s*['\"]DB_NAME['\"]\s*,\s*['\"](.+?)['\"]\s*\)/", $content, $dbname);
preg_match("/define\(\s*['\"]DB_USER['\"]\s*,\s*['\"](.+?)['\"]\s*\)/", $content, $dbuser);
preg_match("/define\(\s*['\"]DB_PASSWORD['\"]\s*,\s*['\"](.+?)['\"]\s*\)/", $content, $dbpass);
preg_match("/define\(\s*['\"]DB_HOST['\"]\s*,\s*['\"](.+?)['\"]\s*\)/", $content, $dbhost);
preg_match("/\\\$table_prefix\s*=\s*['\"](.+?)['\"]/", $content, $dbprefix);

$conn = new mysqli($dbhost[1], $dbuser[1], $dbpass[1], $dbname[1]);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$prefix = isset($dbprefix[1]) ? $dbprefix[1] : 'wp_';
$sql = "UPDATE {$prefix}options SET option_value = 'a:0:{}' WHERE option_name = 'active_plugins'";

if ($conn->query($sql) === TRUE) {
    echo "SUCCESS: All plugins have been deactivated directly in the database.\n";
} else {
    echo "ERROR updating record: " . $conn->error . "\n";
}

$conn->close();
