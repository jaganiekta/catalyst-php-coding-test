# catalyst-php-coding-test
## 1. Logic Test
**foobar.php** is a PHP script that can be executed form the command line. <br>The script will output as below:<br>
- Output the numbers from 1 to 100
* Where the number is divisible by three (3) output the word “foo”
+ Where the number is divisible by five (5) output the word “bar”
- Where the number is divisible by three (3) and (5) output the word “foobar” <br>

**Example**<br>
An example output of the script would look like:<br>
1, 2, foo, 4, bar, foo, 7, 8, foo, bar, 11, foo, 13, 14, foobar …

**Usage:** php foobar.php [options]

**Options:**
 - --start_number : A number greater than 0 from where script will start to print numbers 
                   (default value for start_number is 1)
 * --end_number   : A number greater than 0 at where script will stop to print numbers 
                   (default value for end_number is 100)
 + --help         : Show this help message

## 2. Script Task
**user_upload.php** is a PHP script, which accepts a CSV file as input (see command
line directives below) and processes the CSV file. <br>The parsed file data is to be inserted into a MySQL database.<br>
**users.csv** is a sample csv file for testing purpose.<br>

**Note:** It's important to ensure that the CSV file is properly formatted and matches the expected columns (name, surname, email) in order for the script to work correctly. Also, the script assumes that the CSV file is in the same directory as the script, or you can provide the full path to the file in the `--file` option.<br>

The **user_upload.php** script will handle the following criteria:
- CSV file will contain user data and have three columns: name, surname, email
- CSV file will have an arbitrary list of users
- Script will iterate through the CSV rows and insert each record into a dedicated MySQL database into the table “users”
- The users table can be created using `--create_table` option.
- Name and surname field will be set to be capitalised e.g. from “john” to “John” before being inserted into DB
- Emails will be set to be lower case before being inserted into DB
- The script will validate the email address before inserting, to make sure that it is valid (valid means that it is a legal email format, e.g. “xxxx@asdf@asdf” is not a legal format). In case that an email is invalid, no insert will be made to database and an error message will be reported

The user_upload.php script included these command line options (directives):<br>
- --file [csv file name]   Name of the CSV file to be parsed
- --create_table           Build the MySQL users table
- --dry_run                Run the script without inserting CSV file data into the database
- -u                       MySQL username
- -p                       MySQL password
- -h                       MySQL host
- -d                       MySQL database
- --help                   Show the help message

Usage: php user_upload.php [options]

**Example:** <br>
php user_upload.php --create_table -u your_user_name -p your_password -d dbname -h hostname<br>
This will create table and exit

php user_upload.php --file users.csv -u your_user_name -p your_password -d dbname -h hostname<br>
This will parse the CSV file and insert data into users table of your database

php user_upload.php --file users.csv --dry_run -u your_user_name -p your_password -d dbname -h hostname<br>
This will parse the CSV file but will not insert data into the table

php user_upload.php --file users.csv<br>
This will parse the CSV file and insert data into users table with default MySQL details as below: <br>
- -u: default value root
- -p: default null so if your mysql not configured with password then skip this -p option
- -h: default localhost
- -d: default admin database will create<br>
If users table is not created before using --create_table option then it will ask to create table first


