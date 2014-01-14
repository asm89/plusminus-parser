<?php

namespace Asm89\PlusMinus;

/**
 * Item that has been ++'ed or --'ed.
 */
class Item
{
    const MINUS  = '-';
    const PLUS = '+';

    /**
     * @param string $value
     * @param string $plusOrMinus
     */
    public function __construct($value, $plusOrMinus)
    {
        $this->value     = $value;
        $this->plusOrMinus = $plusOrMinus;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return boolean
     */
    public function isMinus()
    {
        return $this->plusOrMinus === self::MINUS;
    }

    /**
     * @return boolean
     */
    public function isPlus()
    {
        return $this->plusOrMinus === self::PLUS;
    }
}
