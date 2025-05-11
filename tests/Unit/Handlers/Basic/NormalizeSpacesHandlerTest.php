<?php

namespace Tenqz\Lingua\Tests\Unit\Handlers\Basic;

use PHPUnit\Framework\TestCase;
use Tenqz\Lingua\Handlers\Basic\NormalizeSpacesHandler;

class NormalizeSpacesHandlerTest extends TestCase
{
    private NormalizeSpacesHandler $handler;

    protected function setUp(): void
    {
        $this->handler = new NormalizeSpacesHandler();
    }

    /**
     * Test that multiple spaces are normalized to a single space
     */
    public function testNormalizesMultipleSpaces(): void
    {
        $input = "Hello    World";
        $expected = "Hello World";

        $result = $this->handler->handle($input);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test that tabs are converted to spaces
     */
    public function testConvertsTabsToSpaces(): void
    {
        $input = "Hello\t\tWorld";
        $expected = "Hello World";

        $result = $this->handler->handle($input);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test that newlines are converted to spaces
     */
    public function testConvertsNewlinesToSpaces(): void
    {
        $input = "Hello\n\r\nWorld";
        $expected = "Hello World";

        $result = $this->handler->handle($input);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test that mixed whitespace characters are normalized
     */
    public function testNormalizesMixedWhitespace(): void
    {
        $input = "Hello \t \n World";
        $expected = "Hello World";

        $result = $this->handler->handle($input);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test that leading and trailing whitespace is also normalized
     */
    public function testNormalizesLeadingAndTrailingWhitespace(): void
    {
        $input = " \t\n Hello World \t\n ";
        $expected = " Hello World ";

        $result = $this->handler->handle($input);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test with a complex string containing multiple whitespace patterns
     */
    public function testHandlesComplexWhitespacePatterns(): void
    {
        $input = "  Multiple   \t\n spaces \t between   words  ";
        $expected = " Multiple spaces between words ";

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

    /**
     * Test that string with only whitespace is normalized to a single space
     */
    public function testWhitespaceOnlyStringBecomesSpace(): void
    {
        $input = "   \t\n  ";
        $expected = " ";

        $result = $this->handler->handle($input);
        $this->assertEquals($expected, $result);
    }
}
