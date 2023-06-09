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
            email VARCHAR(255) NOT NULL,
            UNIQUE KEY unique_email (email)  
        )
    ";

    if ($mysqli->query($createTableQuery) === true) {
        echo "Table 'users' created successfully.\n";
    } else {
        echo "Error: Failed to create table 'users': " . $mysqli->error . "\n";
        exit(1);
    }

    if(!$file) {
        exit;
    }
}

// Check if the file option is provided
if (empty($file)) {
    echo "Error: Please provide the CSV file using the --file option.\n";
    echo "Run 'php script.php --help' for more information.\n";
    exit(1);
}

if( !file_exists($file) ) {
    echo "Error: File does not exist.";
    exit(1);
}

if( $mysqli->query('select name from users LIMIT 1') === false ) {
    echo "Error: Please create table using --create_table option.\n";
    echo "Run 'php script.php --help' for more information.\n";
    exit(1);
}
// Parse CSV file
$csvData = array_map('str_getcsv', file($file));

// Remove header row
$header = array_shift($csvData);

// Iterate through CSV rows
$insertedRows = 0;
$errors = 0;
if( !empty($csvData) ) {
    foreach ($csvData as $row) {
        $name = mysqli_real_escape_string($mysqli, trim(ucfirst(strtolower($row[0]))));
        $surname = mysqli_real_escape_string($mysqli, trim(ucfirst(strtolower($row[1]))));
        $email = mysqli_real_escape_string($mysqli, trim(strtolower($row[2])));

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Error: Invalid email format for '{$email}'. Skipping insertion.\n";
            $errors++;
            continue;
        }

        // Insert into database or dry run
        if (!$dryRun) {
            $insertQuery = "INSERT INTO users (name, surname, email) VALUES ('$name', '$surname', '$email')";
            if ($mysqli->query($insertQuery) === true) {
                $insertedRows++;
            } else {
                echo "Error: Failed to insert row: " . $mysqli->error . "\n";
                $errors++;
            }
        } else {
            $insertedRows++;
        }
    }
} else {
    echo "Error: Empty file encountred ";
    exit(1);
}

// Output summary
echo "Summary:\n";
if ($dryRun) {
    echo "CSV file parsed successfully and number of rows: {$insertedRows}\n";
} else {
    echo "Inserted rows: {$insertedRows}\n";
}
echo "Errors: {$errors}\n";

// Close database connection
$mysqli->close();