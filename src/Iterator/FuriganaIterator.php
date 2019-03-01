<?php
namespace App\Iterator;

use meCab\meCab;

/**
 * Iterator that attempts to add furigana to elements that contain text content.
 */
class FuriganaIterator extends \IteratorIterator
{
    protected $_iterator = null;
    protected $_mecab = null;

    public function __construct(\Traversable $iterator)
    {
        $this->_mecab = new meCab();
        parent::__construct($iterator);
    }

    /**
     * Very simple check to see if the given string consists of kanji.
     * ref: https://stackoverflow.com/a/2857434/2817470
     *
     * @param string $str
     * @return boolean
     */
    function isKanji(string $str) {
        return preg_match('/[\x{4E00}-\x{9FBF}]/u', $str) > 0;
    }

    /**
     * Get teh current node content, and get readings for any kanji present.
     *
     * @return mixed
     */
    public function current()
    {
        $cur = parent::current();

        // Only act on elements that have content.
        if (isset($cur['content'])) {
            // Get the current text.
            $text = $cur['content'];

            if (!empty($text)) {
                $analysis = $this->_mecab->analysis($text);

                if (empty($analysis)) {
                    return $cur;
                }

                $ret = [];

                // Now we need to iterate through each "part" of the analysis, and
                // get the furigana, or just text.
                foreach ($analysis as $node) {
                    $base_text = $node->getText();
                    // Only add a furigana if the text is kanji.
                    if ($this->isKanji($base_text)) {
                        $reading = $node->getReading();
                        // Convert any katakana readings into hiragana.
                        // c - Convert zenkaku katakana into zenkakau hiragana
                        // H - Convert hankaku katakana into zenkakau hiragana
                        $reading = \mb_convert_kana($reading, 'cH');
                        // Set the content, and furigana to add to the text.
                        $ret[] = [
                            'content' => $base_text,
                            'furigana' => $reading,
                        ];
                    } else {
                        // No kanji found in the string. Just set the content.
                        $ret[] = [
                            'content' => $base_text,
                        ];
                    }
                }

                // Return a 'wordgroup' that contains all the ruby and regular text.
                return [
                    'type' => 'wordgroup',
                    'content' => $ret,
                ];
            }
        }

        return $cur;
    }
}