<?php
namespace App\Writer;

interface WriterInterface
{
    /**
     * Process the $input_iterator to construct a file to save to $filename.
     *
     * @param \Iterator $input_iterator
     * @param string $filename
     * @return void
     */
    public function write(\Iterator $input_iterator, string $filename);
}