<?php

namespace Tenqz\Lingua\Tests\Unit\Handlers\Basic;

use PHPUnit\Framework\TestCase;
use Tenqz\Lingua\Handlers\Basic\SpecialCharsHandler;

class SpecialCharsHandlerTest extends TestCase
{
    private SpecialCharsHandler $handler;

    protected function setUp(): void
    {
        $this->handler = new SpecialCharsHandler();
    }

    /**
     * Test that all special characters are removed
     */
    public function testRemovesAllSpecialCharacters(): void
    {
        $input = "Hello! @#$%^&*() World...";
        $expected = "Hello World";
        
        $result = $this->handler->handle($input);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test that Russian special characters are removed
     */
    public function testRemovesRussianSpecialCharacters(): void
    {
        $input = "Привет! «Мир»...";
        $expected = "Привет Мир";
        
        $result = $this->handler->handle($input);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test that all specified special characters are removed
     */
    public function testRemovesAllSpecifiedCharacters(): void
    {
        $input = "-_+{}|:<>?[];',./\\~`=—«»";
        $expected = "";
        
        $result = $this->handler->handle($input);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test that newlines are replaced with spaces
     */
    public function testReplacesNewlinesWithSpaces(): void
    {
        $input = "Hello\nWorld";
        $expected = "Hello World";
        
        $result = $this->handler->handle($input);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test that multiple newlines are normalized
     */
    public function testNormalizesMultipleNewlines(): void
    {
        $input = "Hello\n\n\nWorld";
        $expected = "Hello World";
        
        $result = $this->handler->handle($input);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test that multiple spaces are normalized
     */
    public function testNormalizesMultipleSpaces(): void
    {
        $input = "Hello    World";
        $expected = "Hello World";
        
        $result = $this->handler->handle($input);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test complex text with mixed special characters and spaces
     */
    public function testHandlesComplexText(): void
    {
        $input = "Hello! @#$%^&*()\nWorld...\n\nTest    Test";
        $expected = "Hello World Test Test";
        
        $result = $this->handler->handle($input);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test text with mixed Russian and English characters
     */
    public function testHandlesMixedLanguages(): void
    {
        $input = "Hello! Привет!\nWorld... Мир...";
        $expected = "Hello Привет World Мир";
        
        $result = $this->handler->handle($input);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test that empty string is handled correctly
     */
    public function testHandlesEmptyString(): void
    {
        $input = "";
        $expected = "";
        
        $result = $this->handler->handle($input);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test that string with only special characters and spaces is handled correctly
     */
    public function testHandlesOnlySpecialCharsAndSpaces(): void
    {
        $input = "! @ # $ % ^ & * ( ) _ + { } | : < > ? [ ] ; ' , . / \\ ~ ` = — « »";
        $expected = "";
        
        $result = $this->handler->handle($input);
        $this->assertEquals($expected, $result);
    }
} 