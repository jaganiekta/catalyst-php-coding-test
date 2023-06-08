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
