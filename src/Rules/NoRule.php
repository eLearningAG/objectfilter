<?php

namespace ELearningAG\ObjectFilter\Rules;

use ELearningAG\ObjectFilter\Rule;

/**
 * An instance of NoRule is always satisfied
 */
class NoRule extends Rule
{

    /**
     * Returns true
     *
     * @param $arg
     * @return bool
     */
    public function check($arg)
    {
        return true;
    }

    public function contains(Rule $other)
    {
        return $other instanceof static;
    }

    /**
     * Return a string representation for the NoRule instance
     *
     * @return string
     */
    public function __toString()
    {
        return '';
    }

    /**
     * Return an array representation for the NoRule instance
     *
     * @return array
     */
    public function toArray()
    {
        return [];
    }
}
