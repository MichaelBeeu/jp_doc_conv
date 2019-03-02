# JP_DOC_CONV

# Purpose
This project attempts to read HTML files searching for text nodes, producing a 'clean' output file consisting of only text, with furigana added above all applicable kanji found within the document.

# Usage
Sample command:
```php -f convert.php input.html output.html```

This will read `input.html` and write output to `output.html`.

# Requirements
This project was written in PHP 7.2.

The following extensions are required:
- xml
- zip

And the following external binaries:
- mecab

# Installation
Ensure the above requirements are met, then run `composer install`.

# TODO
- [ ] Add additional output formats.
    - [ ] ODF
    - [ ] DOCX
    - [ ] PDF
- [ ] More flexible input processing.
- [ ] Add additional stream formatters.
- [ ] Retain images.
- [ ] Maintain formatting for selected tags.
    - [ ] H1-H6
    - [ ] Maintain applied CSS styles
- [ ] More complex processing of command line arguments.
- [ ] Create web interface for document conversion.

# Notes
This project was made with the purpose of processing/converting the following resources in mind:
* https://www.aozora.gr.jp/cards/000154/files/4947_16626.html
* https://www.aozora.gr.jp/cards/000329/files/3390_33153.html