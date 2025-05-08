<?php

namespace Tenqz\Lingua\Tests;

use PHPUnit\Framework\TestCase;
use Tenqz\Lingua\TextProcessor;
use Tenqz\Lingua\Handler\TextHandlerInterface;
use Tenqz\Lingua\Exception\ScenarioNotFoundException;

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
     * Test that process method throws exception for non-existent scenario
     */
    public function testProcessThrowsExceptionForNonExistentScenario(): void
    {
        $this->expectException(ScenarioNotFoundException::class);
        $this->processor->process('non-existent', 'test text');
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

        $this->processor->registerScenario('test', $this->mockHandler);
        
        $result = $this->processor->process('test', $inputText);
        $this->assertEquals($expectedOutput, $result);
    }
} 