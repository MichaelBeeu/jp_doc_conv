<?php
namespace App\Writer;

/**
 * Writer for HTML files.
 */
class HtmlWriter implements WriterInterface
{
    /**
     * Process the $input_iterator to construct an HTML file and save to $filename.
     *
     * @param \Iterator $input_iterator
     * @param string $filename
     * @return void
     */
    public function write(\Iterator $input_iterator, string $filename)
    {
        $document = new \DOMDocument('1.0', 'utf-8');

        // Start document
        $html = $document->appendChild(
            $document->createElement('html')
        );

        $head = $html->appendChild(
            $document->createElement('head')
        );

        // Set up document styles
        $style = $head->appendChild(
            $document->createElement('style')
        );

        $style_attr_type = $document->createAttribute('type');
        $style_attr_type->value = 'text/css';
        $style->appendChild($style_attr_type);

        $style_fragment = $document->createDocumentFragment();

        $style_fragment->appendXML(
            'rt { font-size: 0.7em; }'
        );

        $style->appendChild($style_fragment);

        $body = $html->appendChild(
            $document->createElement('body')
        );

        $p = $document->createElement('p');
        $body->appendChild($p);

        foreach ($input_iterator as $input) {
            $tag = $input['type'];
            if ($tag == 'br') {
                $p = $document->createElement('p');
                $body->appendChild($p);
            } else if ($tag == 'wordgroup') {
                foreach ($input['content'] as $word) {
                    if (isset($word['furigana'])) {
                        // Create containing ruby element.
                        $ruby = $document->createElement('ruby', $word['content']);
                        // Add fallback parenthesis
                        $ruby->appendChild(
                            $document->createElement('rp', '(')
                        );
                        // Add ruby text.
                        $ruby->appendChild(
                            $document->createElement('rt', $word['furigana'])
                        );
                        // Add fallback parenthesis
                        $ruby->appendChild(
                            $document->createElement('rp', ')')
                        );
                        $p->appendChild($ruby);
                    } else {
                        $p->appendChild($document->createTextNode($word['content']));
                    }
                }
            } else {
                $p->appendChild($document->createTextNode($input['content']));
            }
        }

        // Saving as XML file, instead of using SaveHTMLFile, so that the text is not converted
        // into entities.
        file_put_contents($filename, $document->saveXML());
    }
}