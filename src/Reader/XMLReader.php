<?php
namespace App\Reader;
use App\Reader\XMLReader\TagFilter;
use App\Reader\XMLReader\DOMIterator;
use App\Iterator\DomNodeConverterIterator;

/**
 * Read XML file.
 */
class XMLReader implements ReaderInterface
{
    /**
     * The current DOMDocument object.
     *
     * @var \DOMDocument
     */
    private $_document ;

    /**
     * Construct reader for $filename.
     *
     * @param string $filename
     */
    public function __construct(string $filename)
    {
        $this->_document = new \DOMDocument();
        $this->_document->loadXml(file_get_contents($filename));
        $this->_current = $this->_document;
    }

    /**
     * Get iterator for text nodes.
     *
     * @return \Iterator
     */
    public function getTextNodes()
    {
        $xpath = new \DOMXpath($this->_document);
        $xpath->registerNamespace('xhtml', 'http://www.w3.org/1999/xhtml');

        return
            new DomNodeConverterIterator(
                new DOMIterator(
                    // Select text nodes that are not part of any ruby text, and any break elements.
                    // Breaks aren't text nodes, however, they are needed for formatting.
                    $xpath->query('descendant::text()[not(ancestor::xhtml:rp or ancestor::xhtml:rt)]|descendant::xhtml:br')
                )
            );
    }
}