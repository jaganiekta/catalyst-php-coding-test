<?php

// Command line options
$options = getopt("u:p:h:", ["file:", "create_table", "dry_run", "help"]);

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

