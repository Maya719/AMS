<?php
// Execute the command to get the current directory
exec('cd', $output);

// Output the result to a file
$file = 'current_directory.txt';
file_put_contents($file, $output[0]);

echo "Current directory saved to $file.";
?>