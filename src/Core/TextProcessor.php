<?php

namespace Tenqz\Lingua\Core;

use Tenqz\Lingua\Core\Contracts\TextHandlerInterface;
use Tenqz\Lingua\Core\Contracts\TextProcessorInterface;
use Tenqz\Lingua\Core\Exceptions\NotFoundHandlerException;

/**
 * Facade class for managing text processing scenarios
 * Provides a simple interface for registering and executing processing chains
 */
class TextProcessor implements TextProcessorInterface
{
    /**
     * @var TextHandlerInterface|null
     */
    private ?TextHandlerInterface $handlersChain = null;

    /**
     * {@inheritDoc}
     */
    public function addHandler(TextHandlerInterface $handler): self
    {
        if (!$this->handlersChain) {
            $this->handlersChain = $handler;
            return $this;
        }

        $lastHandler = $this->handlersChain;
        while ($lastHandler->getNext()) {
            $lastHandler = $lastHandler->getNext();
        }

        $lastHandler->setNext($handler);
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function process(string $text): string
    {
        if (!$this->handlersChain) {
            throw new NotFoundHandlerException();
        }

        return $this->handlersChain->handle($text);
    }
}
