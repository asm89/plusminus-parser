<?php

namespace Asm89\PlusMinus;

/**
 * Matches ++ and --'ed items.
 */
abstract class Matcher
{
    /**
     * @param string $message
     *
     * @return null|FoundMatch
     */
    abstract public function matchMinus($message);

    /**
     * @param string $message
     *
     * @return null|FoundMatch
     */
    abstract public function matchPlus($message);
}
