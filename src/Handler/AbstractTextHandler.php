<?php

namespace Tenqz\Lingua\Handler;

/**
 * Abstract base class for text processing handlers
 * Implements the Chain of Responsibility pattern
 */
abstract class AbstractTextHandler implements TextHandlerInterface
{
    /**
     * Reference to the next handler in the chain
     * 
     * @var TextHandlerInterface|null
     */
    protected ?TextHandlerInterface $nextHandler = null;

    /**
     * {@inheritDoc}
     */
    public function setNext(TextHandlerInterface $handler): TextHandlerInterface
    {
        $this->nextHandler = $handler;
        return $handler;
    }

    /**
     * {@inheritDoc}
     */
    public function handle(string $text): string
    {
        $processedText = $this->process($text);
        
        if ($this->nextHandler !== null) {
            return $this->nextHandler->handle($processedText);
        }

        return $processedText;
    }

    /**
     * Concrete implementation of text processing
     * Must be implemented by specific handlers
     * 
     * @param string $text Text to process
     * @return string Processed text
     */
    abstract protected function process(string $text): string;
} 