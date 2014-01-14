plusminus-parser
================

A small library to parse ++ and -- messages. For example:

```
asm89 | qbot++
 qbot | current score for qbot: 1337
asm89 | [it handles spaces]++
 qbot | current score for it handles spaces: 42
```

## Installation

Run:

```
composer require asm89/plusminus-parser
```
or add it to your `composer.json` file.

## Usage

Create a parser and pass it the matchers you want to use.

```php
$parser = new Asm89\PlusMinus\MessageParser([
    new Asm89\PlusMinus\WordMatcher(0),
    new Asm89\PlusMinus\BracketMatcher(1), // bracket items take priority
]):

/** @return null|Item */
$item = $parser->parse($message);

// item API
$item->getValue();
$item->isMinus();
$item->isPlus();
```
