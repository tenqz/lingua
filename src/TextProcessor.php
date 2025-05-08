<?php

namespace Tenqz\Lingua;

use Tenqz\Lingua\Handler\TextHandlerInterface;
use Tenqz\Lingua\Exception\ScenarioNotFoundException;

/**
 * Facade class for managing text processing scenarios
 * Provides a simple interface for registering and executing processing chains
 */
class TextProcessor
{
    /**
     * Registered processing scenarios
     * 
     * @var array<string, TextHandlerInterface>
     */
    private array $scenarios = [];

    /**
     * Register a new processing scenario
     * 
     * @param string $name Scenario name
     * @param TextHandlerInterface $handler First handler in the processing chain
     * @return self Returns $this for method chaining
     */
    public function registerScenario(string $name, TextHandlerInterface $handler): self
    {
        $this->scenarios[$name] = $handler;
        return $this;
    }

    /**
     * Process text using the specified scenario
     * 
     * @param string $scenario Name of the scenario to use
     * @param string $text Text to process
     * @return string Processed text
     * @throws ScenarioNotFoundException If the specified scenario is not found
     */
    public function process(string $scenario, string $text): string
    {
        if (!isset($this->scenarios[$scenario])) {
            throw new ScenarioNotFoundException($scenario);
        }

        return $this->scenarios[$scenario]->handle($text);
    }
} 