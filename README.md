# Lingua

Lingua is a comprehensive PHP library designed for advanced text processing. It implements the Chain of Responsibility pattern to provide flexible and extensible text processing capabilities.

> **Note:** This library is currently under active development. The current version may not reflect the final quality and API stability. Breaking changes may occur in future releases.

## Features

- Chain of Responsibility pattern for text processing
- Flexible scenario-based processing
- Easy to extend with custom handlers
- PHP 8.0+ support

## Installation

```bash
composer require tenqz/lingua
```

## Basic Usage

```php
use Tenqz\Lingua\TextProcessor;
use Tenqz\Lingua\Handler\TextHandlerInterface;

// Create a custom handler
class CustomHandler extends AbstractTextHandler
{
    protected function process(string $text): string
    {
        // Your text processing logic here
        return $text;
    }
}

// Initialize the processor
$processor = new TextProcessor();

// Register a processing scenario
$handler = new CustomHandler();
$processor->registerScenario('custom', $handler);

// Process text
$result = $processor->process('custom', 'Your text here');
```

## Architecture

The library consists of the following main components:

### TextHandlerInterface

Interface that defines the contract for all text processing handlers:

```php
interface TextHandlerInterface
{
    public function handle(string $text): string;
    public function setNext(TextHandlerInterface $handler): TextHandlerInterface;
}
```

### AbstractTextHandler

Abstract base class that implements the Chain of Responsibility pattern:

```php
abstract class AbstractTextHandler implements TextHandlerInterface
{
    protected ?TextHandlerInterface $nextHandler = null;

    public function setNext(TextHandlerInterface $handler): TextHandlerInterface
    {
        $this->nextHandler = $handler;
        return $handler;
    }

    public function handle(string $text): string
    {
        $processedText = $this->process($text);
        
        if ($this->nextHandler !== null) {
            return $this->nextHandler->handle($processedText);
        }

        return $processedText;
    }

    abstract protected function process(string $text): string;
}
```

### TextProcessor

Facade class for managing text processing scenarios:

```php
class TextProcessor
{
    private array $scenarios = [];

    public function registerScenario(string $name, TextHandlerInterface $handler): self
    {
        $this->scenarios[$name] = $handler;
        return $this;
    }

    public function process(string $scenario, string $text): string
    {
        if (!isset($this->scenarios[$scenario])) {
            throw new ScenarioNotFoundException($scenario);
        }

        return $this->scenarios[$scenario]->handle($text);
    }
}
```

## Creating Custom Handlers

To create a custom handler, extend the `AbstractTextHandler` class and implement the `process` method:

```php
class MyCustomHandler extends AbstractTextHandler
{
    protected function process(string $text): string
    {
        // Your text processing logic here
        return $text;
    }
}
```

## Error Handling

The library throws the following exceptions:

- `ScenarioNotFoundException`: Thrown when attempting to process text with a non-existent scenario

## Testing

```bash
composer test
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Author

Oleg Patsay <smmartbiz@gmail.com> 