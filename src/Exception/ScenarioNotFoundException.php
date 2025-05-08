<?php

namespace Tenqz\Lingua\Exception;

/**
 * Exception thrown when a requested processing scenario is not found
 */
class ScenarioNotFoundException extends \RuntimeException
{
    /**
     * @param string $scenario Name of the scenario that was not found
     */
    public function __construct(string $scenario)
    {
        $message = sprintf('Processing scenario "%s" not found', $scenario);
        parent::__construct($message);
    }
} 