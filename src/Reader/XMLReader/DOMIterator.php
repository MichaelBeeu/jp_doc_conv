<?php
namespace App\Reader\XMLReader;

/**
 * Special iterator for DOMNodeList. There exists a bug in PHP that doesn't
 * allow a regular IteratorIterator to function properly on a DOMNodeList.
 * ref: https://bugs.php.net/bug.php?id=60762&edit=1
 */
class DOMIterator extends \IteratorIterator
{
    /**
     * Current index within the nodelist.
     *
     * @var integer
     */
    protected $_idx = 0;

    protected $_stack = [];

    /**
     * Construct DOMIterator. Redfined in order to set type on $iterator
     *
     * @param \DOMNodeList $iterator
     * @return void
     */
    public function __construct(\DOMNodeList $iterator)
    {
        parent::__construct($iterator);
    }

    /**
     * Return the current node.
     *
     * @return DOMNode
     */
    public function current()
    {
        return $this->getInnerIterator()->item($this->_idx);
    }

    /**
     * Move to the next node.
     *
     * @return void
     */
    public function next()
    {
        $this->_idx ++;
    }

    /**
     * Reset iterator to beginning of node list.
     *
     * @return void
     */
    public function rewind()
    {
        $this->_idx = 0;
    }

    /**
     * Return the current key.
     *
     * @return void
     */
    public function key()
    {
        return $this->_idx;
    }

    /**
     * Test if current id is valid.
     *
     * @return boolean
     */
    public function valid()
    {
        $inner = $this->getInnerIterator();
        return $this->_idx >= 0 && $this->_idx < $inner->count();
    }
}