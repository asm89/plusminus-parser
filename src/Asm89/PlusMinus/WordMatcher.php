<?php

namespace Asm89\PlusMinus;

/**
 * Matches words followed by ++ or --.
 */
class WordMatcher extends Matcher
{
    private $priority;

    /**
     * @param integer $priority
     */
    public function __construct($priority)
    {
        $this->priority = $priority;
    }

    /**
     * {@inheritDoc}
     */
    public function matchMinus($message)
    {
        return $this->match($message, Item::MINUS, '--');
    }

    /**
     * {@inheritDoc}
     */
    public function matchPlus($message)
    {
        return $this->match($message, Item::PLUS, '++');
    }

    private function match($message, $type, $matchString)
    {
        if ( ! $end = strpos($message, $matchString)) {
            return;
        }

        $start = $this->findStartOfWord($message, $end - 1);

        if ($end === $start) {
            return;
        }

        return new FoundMatch($message, $start, $type, $start, $end, $this->priority);
    }

    private function findStartOfWord($string, $end)
    {
        for ($i = $end; $i > 0; $i--) {
            if ($string[$i] === ' ') {
                return $i + 1;
            }
        }

        return 0;
    }
}
