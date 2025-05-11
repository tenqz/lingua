<p align="center">
<a href="https://github.com/tenqz/lingua/actions"><img src="https://github.com/tenqz/lingua/workflows/Tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/tenqz/lingua"><img src="https://img.shields.io/packagist/dt/tenqz/lingua" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/tenqz/lingua"><img src="https://img.shields.io/packagist/v/tenqz/lingua" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/tenqz/lingua"><img src="https://img.shields.io/packagist/l/tenqz/lingua" alt="License"></a>
</p>

# Lingua v2.0.1

Lingua is a comprehensive PHP library designed for advanced text processing. It implements the Chain of Responsibility pattern to provide flexible and extensible text processing capabilities.

> **Note:** This library is currently under active development. The current version may not reflect the final quality and API stability. Breaking changes may occur in future releases.

## Features

- Chain of Responsibility pattern for text processing
- Flexible scenario-based processing
- Easy to extend with custom handlers
- PHP 8.1+ support

## Available Handlers

The library provides several built-in text processing handlers:

### SpecialCharsHandler

Removes special characters from text while preserving words and spaces. This handler:
- Removes all special characters (punctuation marks, symbols, etc.)
- Replaces newlines with spaces
- Normalizes multiple spaces into single spaces
- Trims spaces from the beginning and end of text

Example:
```php
use Tenqz\Lingua\Handlers\Basic\SpecialCharsHandler;

$handler = new SpecialCharsHandler();
$result = $handler->handle("Hello! @#$%^&*() World..."); // Returns: "Hello World"
```

### HtmlTagsHandler

Removes HTML tags from text while preserving the content between them. This handler:
- Removes all HTML tags using PHP's `strip_tags` function
- Preserves HTML entities
- Normalizes multiple spaces into single spaces
- Trims spaces from the beginning and end of text

Example:
```php
use Tenqz\Lingua\Handlers\Basic\HtmlTagsHandler;

$handler = new HtmlTagsHandler();
$result = $handler->handle("<p>Hello</p> <div>World</div>"); // Returns: "HelloWorld"
$result = $handler->handle("<p>Hello &amp; World</p>"); // Returns: "Hello &amp; World"
```

## Installation

```bash
composer require tenqz/lingua
```

## Basic Usage

```php
use Tenqz\Lingua\Core\TextProcessor;
use Tenqz\Lingua\Core\AbstractTextHandler;
use Tenqz\Lingua\Core\Contracts\TextHandlerInterface;

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

// Add handlers to the chain
$processor->addHandler(new CustomHandler());

// Process text
$result = $processor->process('Your text here');
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
    public function getNext(): ?TextHandlerInterface;
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
    
    public function getNext(): ?TextHandlerInterface
    {
        return $this->nextHandler;
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

Facade class for managing text processing chains:

```php
class TextProcessor implements TextProcessorInterface
{
    private ?TextHandlerInterface $handlersChain = null;

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

    public function process(string $text): string
    {
        if (!$this->handlersChain) {
            throw new NotFoundHandlerException();
        }

        return $this->handlersChain->handle($text);
    }
}
```

## Creating Custom Handlers

To create a custom handler, extend the `AbstractTextHandler` class and implement the `process` method:

```php
use Tenqz\Lingua\Core\AbstractTextHandler;

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

- `NotFoundHandlerException`: Thrown when attempting to process text with no registered handlers

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

This project is licensed under the MIT License
