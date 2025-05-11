<?php

namespace Tenqz\Lingua\Core\Contracts;

/**
 * Interface for text processing handlers in the Chain of Responsibility pattern
 */
interface TextHandlerInterface
{
    /**
     * Process the input text
     *
     * @param string $text Input text to process
     * @return string Processed text
     */
    public function handle(string $text): string;

    /**
     * Set the next handler in the chain
     *
     * @param TextHandlerInterface $handler Next handler in the chain
     * @return TextHandlerInterface Returns the next handler for method chaining
     */
    public function setNext(TextHandlerInterface $handler): TextHandlerInterface;

    /**
     * Get the next handler in the chain
     *
     * @return TextHandlerInterface|null
     */
    public function getNext(): ?TextHandlerInterface;
}
