<?php

namespace Tenqz\Lingua\Handlers\Basic;

use Tenqz\Lingua\Core\AbstractTextHandler;

/**
 * Handler for removing whitespace from the beginning and end of text
 * Removes all whitespace characters from the beginning and end of the input text
 */
class TrimHandler extends AbstractTextHandler
{
    /**
     * Process text by trimming whitespace from beginning and end
     * 
     * @param string $text Input text to trim
     * @return string Processed text without leading and trailing whitespace
     */
    protected function process(string $text): string
    {
        // Remove whitespace from beginning and end of the string
        return trim($text);
    }
} 