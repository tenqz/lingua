<?php

namespace Tenqz\Lingua\Handlers\Basic;

use Tenqz\Lingua\Core\AbstractTextHandler;

/**
 * Handler for normalizing whitespace in text
 * Replaces consecutive whitespace characters (spaces, tabs, newlines) with a single space
 */
class NormalizeSpacesHandler extends AbstractTextHandler
{
    /**
     * Process text by normalizing whitespace
     * 
     * @param string $text Input text with potential multiple spaces/tabs
     * @return string Processed text with normalized whitespace
     */
    protected function process(string $text): string
    {
        // Replace all whitespace sequences with a single space
        return preg_replace('/\s+/', ' ', $text);
    }
} 