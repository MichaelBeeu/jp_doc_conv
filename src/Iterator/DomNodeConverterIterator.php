<?php
namespace App\Iterator;

/**
 * Convert nodes into the array type we're using to pass data around.
 */
class DomNodeConverterIterator extends \IteratorIterator
{

    /**
     * Get the current node, and convert to a simple array.
     *
     * @return array
     */
    public function current()
    {
        $node = parent::current();

        // Only look for text nodes, or specific tag types.
        if ($node instanceof \DOMText) {
            // Text can be passed as it is.
            return [
                'type' => 'text',
                'content' => $node->textContent,
            ];
        } else {
            // Look for break tags, and produce a 'br' type.
            $tagName = $node->tagName;
            if ($tagName == 'br') {
                return [
                    'type' => 'br',
                ];
            }
        }
        // For anything else return an empty 'text' element.
        return [
            'type' => 'text',
            'content' => '',
        ];
    }
}