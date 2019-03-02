<?php
require "vendor/autoload.php";
use App\Reader\XMLReader;
use App\Writer\HtmlWriter;
use App\Iterator\FuriganaIterator;

$output_filename = '-';
$input_filename = '-';

// Perform very basic argument handling.
// TODO: Implement more complex handling of arguments. See getopt()

if (!isset($argv[1])) {
    // Print usage if the minimum number of arguments has not been provided.
    echo "Usage: {$argv[0]} <input-filename> [output-filename]" . PHP_EOL;
    exit(1);
}

$input_filename = $argv[1];

// Set the output filename.
if (isset($argv[2])) {
    $output_filename = $argv[2];
}

// Convert dashes to the correct stream name.
// This allows a user to specify stdin and stdout with a single character (similiar
// to some other unix commands.)
if ($output_filename == '-') {
    $output_filename = 'php://output';
}
if ($input_filename == '-') {
    $input_filename = 'php://input';
}

// Create reader and writer objects for the document.
$reader = new XMLReader($input_filename);
$writer = new HtmlWriter();

// Construct the 'pipeline' for processing the document.
// TODO: Allow other filters, converters to be added in sequence.
$document_pipeline = new FuriganaIterator($reader->getTextNodes());

// Process the 'pipeline' and save the document.
$writer->write($document_pipeline, $output_filename);