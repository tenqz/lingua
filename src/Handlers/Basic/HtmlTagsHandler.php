<?php

namespace Tenqz\Lingua\Handlers\Basic;

use Tenqz\Lingua\Core\AbstractTextHandler;

/**
 * Handler for removing HTML tags from text
 * Removes all HTML tags while preserving the content between them
 */
class HtmlTagsHandler extends AbstractTextHandler
{
    /**
     * Process text by removing HTML tags
     *
     * @param string $text Input text with HTML tags
     * @return string Processed text without HTML tags
     */
    protected function process(string $text): string
    {
        // Remove all HTML tags using strip_tags
        $text = strip_tags($text);

        // Normalize spaces (replace multiple spaces with single space)
        $text = preg_replace('/\s+/', ' ', $text);

        // Remove spaces from beginning and end
        return trim($text);
    }
}
