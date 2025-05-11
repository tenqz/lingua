<?php

namespace Tenqz\Lingua\Tests\Unit\Handlers\Basic;

use PHPUnit\Framework\TestCase;
use Tenqz\Lingua\Handlers\Basic\TrimHandler;

class TrimHandlerTest extends TestCase
{
    private TrimHandler $handler;

    protected function setUp(): void
    {
        $this->handler = new TrimHandler();
    }

    /**
     * Test that whitespace is removed from beginning and end
     */
    public function testTrimsWhitespace(): void
    {
        $input = "  Hello World  ";
        $expected = "Hello World";
        
        $result = $this->handler->handle($input);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test that tabs and newlines are also trimmed
     */
    public function testTrimsTabsAndNewlines(): void
    {
        $input = "\t\nHello World\t\n";
        $expected = "Hello World";
        
        $result = $this->handler->handle($input);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test that whitespace is only removed from beginning and end, not between words
     */
    public function testPreservesWhitespaceBetweenWords(): void
    {
        $input = "  Hello   World  ";
        $expected = "Hello   World";
        
        $result = $this->handler->handle($input);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test that a string with only whitespace becomes empty
     */
    public function testEmptyResultForWhitespaceOnlyString(): void
    {
        $input = "   \t\n  ";
        $expected = "";
        
        $result = $this->handler->handle($input);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test that an already trimmed string remains unchanged
     */
    public function testNoChangeForAlreadyTrimmedString(): void
    {
        $input = "Hello World";
        $expected = "Hello World";
        
        $result = $this->handler->handle($input);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test that empty string remains empty
     */
    public function testEmptyStringRemainsEmpty(): void
    {
        $input = "";
        $expected = "";
        
        $result = $this->handler->handle($input);
        $this->assertEquals($expected, $result);
    }
} 