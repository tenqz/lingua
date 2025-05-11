<?php

namespace Tenqz\Lingua\Core\Contracts;

/**
 * Interface for text processor
 * Defines the contract for text processing operations
 */
interface TextProcessorInterface
{
    /**
     * Register a new text processing handler
     * 
     * @param TextHandlerInterface $handler Handler to add to the processing chain
     * @return self Returns $this for method chaining
     */
    public function addHandler(TextHandlerInterface $handler): self;

    /**
     * Process text through the handler chain
     * 
     * @param string $text Text to process
     * @return string Processed text
     * @throws \Tenqz\Lingua\Core\Exceptions\NotFoundHandlerException If no handlers are registered
     */
    public function process(string $text): string;
} 