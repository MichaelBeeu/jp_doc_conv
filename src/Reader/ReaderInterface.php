<?php
namespace App\Reader;

/**
 * Document reader interface.
 */
interface ReaderInterface
{
    /**
     * Read nodes from the document.
     * This should return an iterator that returns node information for each
     * text element in the document.
     *
     * @return \Iterator
     */
    public function getTextNodes();
}