<?php

namespace Tenqz\Lingua\Handlers\Basic;

use Tenqz\Lingua\Core\AbstractTextHandler;

/**
 * Handler for removing special characters from text
 * Removes all special characters that are not part of words
 */
class SpecialCharsHandler extends AbstractTextHandler
{
    /**
     * List of special characters to remove
     */
    private const SPECIAL_CHARS = [
        '-', '"', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+', '{', '}', '|', ':', '<', '>',
        '?', '[', ']', ';', "'", ',', '.', '/', '\\', '~', '`', '=', '—', '«', '»'
    ];

    /**
     * Process text by removing special characters
     *
     * @param string $text Input text
     * @return string Processed text without special characters
     */
    protected function process(string $text): string
    {
        // Replace newlines with spaces
        $text = str_replace(["\n", "\r"], ' ', $text);

        // Escape special characters for use in regex
        $escapedChars = array_map(fn($char) => preg_quote($char, '/'), self::SPECIAL_CHARS);

        // Create pattern that matches any of the special characters
        $pattern = '/[' . implode('', $escapedChars) . ']/u';

        // Remove special characters while preserving spaces
        return preg_replace($pattern, '', $text);
    }
}
