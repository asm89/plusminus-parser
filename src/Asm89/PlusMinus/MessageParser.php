<?php

namespace Asm89\PlusMinus;

/**
 * Parses messages.
 */
class MessageParser
{
    private $matchers;

    /**
     * @param array $matchers
     */
    public function __construct($matchers)
    {
        $this->matchers = $matchers;
    }

    /**
     * @param string $message
     *
     * @return null|Item
     */
    public function parse($message)
    {
        $matches = $this->getPossibleMatches($message);

        if (empty($matches)) {
            return null;
        }

        return $matches[0]->toItem();
    }

    private function getPossibleMatches($message)
    {
        $matches = [];

        foreach ($this->matchers as $matcher) {
            $matches[] = $matcher->matchPlus($message);
            $matches[] = $matcher->matchMinus($message);
        }

        $matches = array_filter($matches);

        usort($matches, function($result, $elem) {
            return $elem->outmatches($result);
        });

        return $matches;
    }
}
