<?php

namespace Asm89\PlusMinus;

/**
 * Represents a match on an item.
 */
class FoundMatch
{
    private $message;
    private $end;
    private $start;
    private $type;
    private $position;
    private $priority;

    /**
     * @param string  $message
     * @param integer $position
     * @param string  $type
     * @param integer $start
     * @param integer $end
     * @param integer $priority
     */
    public function __construct($message, $position, $type, $start, $end, $priority)
    {
        $this->message   = $message;
        $this->position  = $position;
        $this->type      = $type;
        $this->start     = $start;
        $this->end       = $end;
        $this->priority  = $priority;
    }

    /**
     * Checks if the item outmatches the other item. Will favor matches with a
     * higher priority.
     *
     * @param FoundMatch $other
     *
     * @return boolean
     */
    public function outmatches(FoundMatch $other)
    {
        if ($other->position == $this->position) {
            return $this->priority > $other->priority;
        }

        return $this->position < $other->position;
    }

    /**
     * @return Item
     */
    public function toItem()
    {
        return new Item($this->extractValue(), $this->type);
    }

    private function extractValue()
    {
        return substr($this->message, $this->start, $this->end - $this->start);
    }
}
