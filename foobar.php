<?php 
// Command line options
$options = getopt("",["start_number:", "end_number:", "help"]);

// Help message
$helpMessage = "
Usage: php foobar.php [options]

Options:
  --start_number   A number greater than 0 from where script will start to print numbers 
                   (default value for start_number is 1)
  --end_number     A number greater than 0 at where script will stop to print numbers 
                   (default value for end_number is 100)
  --help           Show this help message
";

// Check for help option
if (isset($options['help'])) {
    echo $helpMessage;
    exit;
}

$start_number=$options['start_number'] ?? 1;
$end_number=$options['end_number'] ?? 100;

// Validate numbers
if( !is_numeric($start_number) || !is_numeric($end_number) ) {
	echo "Error: A non-numeric value encountered, please pass valid numbers: ";
    exit(1);
}

if ($start_number < 0 ) {
    echo "Error: Please pass valid start_number: ";
    exit(1);
}

if ($end_number < 0 ) {
    echo "Error: Please pass valid end_number: ";
    exit(1);
}

if ($start_number >  $end_number ) {
    echo "Error: You can not pass start_number greater than end_number: ";
    exit(1);
}

// Print numbers from start_number to end_number
for ($x = $start_number; $x <= $end_number; $x++) {
	if($x%3 == 0 AND $x%5 == 0) {
    	echo ($x < $end_number) ? "foobar," : "foobar";
    } else if($x%3 == 0) {
    	echo ($x < $end_number) ? "foo," : "foo";
    } else if($x%5 == 0) {
    	echo ($x < $end_number) ? "bar," : "bar";
    } else {
    	echo ($x < $end_number) ? "$x," : $x;
    }
}
?>  