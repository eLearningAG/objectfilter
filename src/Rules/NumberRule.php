<?php

namespace ELearningAG\ObjectFilter\Rules;

use ELearningAG\ObjectFilter\Rule;

/**
 * An instance of NumberRule checks if the argument is equal to a certain number
 *
 */
class NumberRule extends Rule
{

    /**
     * The certain number
     *
     * @var float|int
     */
    private $number;

    /**
     * Construct a new NumberRule instance for $number
     *
     * @param $number
     */
    public function __construct($number)
    {
        if(is_string($number)) {
            $number = ctype_digit($number) ? (int)$number : (float)$number;
        }
        $this->number = $number;
    }

    /**
     * Check if $other is equal to $number
     *
     * @param $other
     * @return bool
     */
    public function check($other)
    {
        if(is_object($other) && isset($other->id)) {
            return $other->id === $this->number;
        }
        if(is_string($other)) {
            $other = (float)$other;
        }


        return $this->number === $other;
    }

    /**
     * Return a string representation of number
     *
     * @return string
     */
    public function __toString()
    {
        return $this->number;
    }
}