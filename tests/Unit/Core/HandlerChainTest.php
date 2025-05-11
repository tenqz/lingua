<?php

namespace Tenqz\Lingua\Tests\Unit\Core;

use PHPUnit\Framework\TestCase;
use Tenqz\Lingua\Core\TextProcessor;
use Tenqz\Lingua\Handlers\Basic\SpecialCharsHandler;
use Tenqz\Lingua\Handlers\Basic\NormalizeSpacesHandler;
use Tenqz\Lingua\Handlers\Basic\TrimHandler;

class HandlerChainTest extends TestCase
{
    private TextProcessor $processor;

    protected function setUp(): void
    {
        $this->processor = new TextProcessor();
    }

    /**
     * Test that chain of handlers processes text correctly
     */
    public function testProcessWithMultipleHandlers(): void
    {
        // Build processing chain: SpecialChars -> NormalizeSpaces -> Trim
        $this->processor
            ->addHandler(new SpecialCharsHandler())
            ->addHandler(new NormalizeSpacesHandler())
            ->addHandler(new TrimHandler());
        
        // Text with special characters, extra spaces and newlines
        $input = "  Hello! @#$%^&*()\nWorld...\n\nTest    Test  ";
        
        // After SpecialCharsHandler: "  Hello  World   Test    Test  "
        // After NormalizeSpacesHandler: " Hello World Test Test "
        // After TrimHandler: "Hello World Test Test"
        $expected = "Hello World Test Test";
        
        $result = $this->processor->process($input);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test different order of handlers in chain
     */
    public function testDifferentHandlerOrder(): void
    {
        // Build processing chain: Trim -> NormalizeSpaces -> SpecialChars
        $this->processor
            ->addHandler(new TrimHandler())
            ->addHandler(new NormalizeSpacesHandler())
            ->addHandler(new SpecialCharsHandler());
        
        // Text with special characters, extra spaces and newlines
        $input = "  Hello! @#$%^&*()\nWorld...\n\nTest    Test  ";
        
        // After TrimHandler: "Hello! @#$%^&*()\nWorld...\n\nTest    Test"
        // After NormalizeSpacesHandler: "Hello! @#$%^&*() World... Test Test"
        // After SpecialCharsHandler: "Hello  World Test Test"
        $expected = "Hello  World Test Test";
        
        $result = $this->processor->process($input);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test all three handlers with simple text
     */
    public function testAllThreeHandlersWithSimpleText(): void
    {
        $this->processor
            ->addHandler(new SpecialCharsHandler())
            ->addHandler(new NormalizeSpacesHandler())
            ->addHandler(new TrimHandler());
        
        $input = "   Hello,   World!   ";
        $expected = "Hello World";
        
        $result = $this->processor->process($input);
        $this->assertEquals($expected, $result);
    }
} 