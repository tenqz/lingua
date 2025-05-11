<?php

namespace Tenqz\Lingua\Tests\Unit\Handlers\Basic;

use PHPUnit\Framework\TestCase;
use Tenqz\Lingua\Handlers\Basic\HtmlTagsHandler;

class HtmlTagsHandlerTest extends TestCase
{
    private HtmlTagsHandler $handler;

    protected function setUp(): void
    {
        $this->handler = new HtmlTagsHandler();
    }

    /**
     * Test that basic HTML tags are removed
     */
    public function testRemovesBasicHtmlTags(): void
    {
        $input = "<p>Hello</p> <div>World</div>";
        $expected = "Hello World";
        
        $result = $this->handler->handle($input);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test that HTML tags with attributes are removed
     */
    public function testRemovesHtmlTagsWithAttributes(): void
    {
        $input = "<div class=\"test\" id=\"example\">Content</div>";
        $expected = "Content";
        
        $result = $this->handler->handle($input);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test that nested HTML tags are removed
     */
    public function testRemovesNestedHtmlTags(): void
    {
        $input = "<div><p>Hello <strong>World</strong></p></div>";
        $expected = "Hello World";
        
        $result = $this->handler->handle($input);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test that HTML comments are removed
     */
    public function testRemovesHtmlComments(): void
    {
        $input = "Hello <!-- This is a comment --> World";
        $expected = "Hello World";
        
        $result = $this->handler->handle($input);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test that multiple spaces between tags are normalized
     */
    public function testNormalizesSpacesBetweenTags(): void
    {
        $input = "<div>Hello</div>    <p>World</p>";
        $expected = "Hello World";
        
        $result = $this->handler->handle($input);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test complex HTML with mixed content
     */
    public function testHandlesComplexHtml(): void
    {
        $input = "<html><body><h1>Title</h1><p>This is a <strong>test</strong> paragraph.</p><!-- Comment --><ul><li>Item 1</li><li>Item 2</li></ul></body></html>";
        $expected = "TitleThis is a test paragraph.Item 1Item 2";
        
        $result = $this->handler->handle($input);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test handling of HTML entities
     */
    public function testPreservesHtmlEntities(): void
    {
        $input = "<p>This &amp; that &lt;example&gt;</p>";
        $expected = "This &amp; that &lt;example&gt;";
        
        $result = $this->handler->handle($input);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test that self-closing tags are removed
     */
    public function testRemovesSelfClosingTags(): void
    {
        $input = "Text with <br/> line break and <img src=\"example.jpg\" alt=\"Example\"/> image.";
        $expected = "Text with line break and image.";
        
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
     * Test that text without HTML tags is unchanged
     */
    public function testHandlesPlainText(): void
    {
        $input = "Hello World";
        $expected = "Hello World";
        
        $result = $this->handler->handle($input);
        $this->assertEquals($expected, $result);
    }
} 