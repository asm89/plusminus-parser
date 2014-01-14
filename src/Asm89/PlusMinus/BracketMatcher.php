<?php

namespace Asm89\PlusMinus;

/**
 * Matches items contained in [].
 */
class BracketMatcher extends Matcher
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
        return $this->match($message, Item::MINUS, '#\]\-\-(\s|$)#');
    }

    /**
     * {@inheritDoc}
     */
    public function matchPlus($message)
    {
        return $this->match($message, Item::PLUS, '#\]\+\+(\s|$)#');
    }

    private function match($message, $type, $matchString)
    {
        if ( ! $end = $this->findEndingBracket($message, $matchString)) {
            return;
        }

        $start      = $this->findStartingBracket($message, $end);
        $valueStart = $start + 1;

        if (false === $start || $end === $valueStart) {
            return;
        }

        return new Match($message, $start, $type, $valueStart, $end, $this->priority);
    }

    private function findEndingBracket($message, $matchString)
    {
        if ( ! $matchCount = preg_match_all($matchString, $message, $matches, PREG_OFFSET_CAPTURE)) {
            return;
        }

        return $matches[0][$matchCount - 1][1]; // the offset
    }

    private function findStartingBracket($string, $end)
    {
        $position = false;

        for ($i = $end; $i >= 0; $i--) {
            if ($string[$i] === '[') {
                $position = $i;
            }
        }

        return $position;
    }
}
