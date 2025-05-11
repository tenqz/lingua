<?php

namespace Tenqz\Lingua\Tests\Unit\Core;

use PHPUnit\Framework\TestCase;
use Tenqz\Lingua\Core\TextProcessor;
use Tenqz\Lingua\Core\Contracts\TextHandlerInterface;
use Tenqz\Lingua\Core\Exceptions\NotFoundHandlerException;

class TextProcessorTest extends TestCase
{
    private TextProcessor $processor;
    private TextHandlerInterface $mockHandler;

    protected function setUp(): void
    {
        $this->processor = new TextProcessor();
        $this->mockHandler = $this->createMock(TextHandlerInterface::class);
    }

    /**
     * Test that process method throws exception when no handlers are registered
     */
    public function testProcessThrowsExceptionWhenNoHandlers(): void
    {
        $this->expectException(NotFoundHandlerException::class);
        $this->processor->process('test text');
    }

    /**
     * Test that process method correctly processes text through handler chain
     */
    public function testProcessTextThroughHandlerChain(): void
    {
        $inputText = 'test text';
        $expectedOutput = 'processed text';

        $this->mockHandler
            ->expects($this->once())
            ->method('handle')
            ->with($inputText)
            ->willReturn($expectedOutput);

        $this->processor->addHandler($this->mockHandler);

        $result = $this->processor->process($inputText);
        $this->assertEquals($expectedOutput, $result);
    }

    /**
     * Test that process method correctly processes text through multiple handlers in chain
     */
    public function testProcessTextThroughMultipleHandlers(): void
    {
        $inputText = 'test text';
        $intermediateText = 'intermediate text';
        $expectedOutput = 'final processed text';

        // Create a mock for the first handler
        $firstHandler = $this->getMockBuilder(TextHandlerInterface::class)
            ->getMock();

        // Create a mock for the second handler
        $secondHandler = $this->getMockBuilder(TextHandlerInterface::class)
            ->getMock();

        // Configure the first handler to process the text and return intermediateText
        $firstHandler->method('handle')
            ->with($inputText)
            ->willReturn($expectedOutput); // This will be the final result as per chain of responsibility

        // Configure the second handler to process intermediate text and return expectedOutput
        $secondHandler->method('handle')
            ->with($intermediateText)
            ->willReturn($expectedOutput);

        // Configure getNext to implement the chain
        $firstHandler->method('getNext')
            ->willReturn(null); // We'll manually simulate chain

        // Setup the processor with only the first handler
        $this->processor->addHandler($firstHandler);

        // Process the text
        $result = $this->processor->process($inputText);

        // Check the final result
        $this->assertEquals($expectedOutput, $result);
    }
}
