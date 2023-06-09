<?php

// Command line options
$options = getopt("u:p:h:d:", ["file:", "create_table", "dry_run", "help"]);

// Help message
$helpMessage = "
Insert data from PHP CSV to MySQL Databse

Usage: php user_upload.php [options]

Options:
  --file [csv file name]   Name of the CSV file to be parsed
  --create_table           Build the MySQL users table and exit
  --dry_run                Run the script without inserting into the database
  -u                       MySQL username
  -p                       MySQL password
  -h                       MySQL host
  -d                       MySQL database
  --help                   Show this help message
";

// Check for help option
if (isset($options['help'])) {
    echo $helpMessage;
    exit;
}

// Validate and process options
$file = $options['file'] ?? '';
$createTable = isset($options['create_table']);
$dryRun = isset($options['dry_run']);
$username = $options['u'] ?? 'root';
$password = $options['p'] ?? '';
$host = $options['h'] ?? 'localhost';
$dbname = $options['d'] ?? 'admin';

// Connect to MySQL server
$mysqli = new mysqli($host, $username, $password);
if ($mysqli->connect_errno) {
    echo "Error: Failed to connect to MySQL: " . $mysqli->connect_error . "\n";
    exit(1);
}

$createDbSql = "CREATE DATABASE IF NOT EXISTS " . $dbname;
if ($mysqli->query($createDbSql) === TRUE) {
   echo "Database created successfully";
} else {
  echo "Error creating database: " . $mysqli->error;
  exit(1);
}

// Create or rebuild the users table if requested
mysqli_select_db($mysqli, $dbname);
if ($createTable) {
    $createTableQuery = "
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            surname VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL
        )
    ";

    if ($mysqli->query($createTableQuery) === true) {
        echo "Table 'users' created successfully.\n";
    } else {
        echo "Error: Failed to create table 'users': " . $mysqli->error . "\n";
        exit(1);
    }

    exit;
}