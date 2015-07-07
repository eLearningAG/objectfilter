<?php

namespace ELearningAG\ObjectFilter\Rules;

use ELearningAG\ObjectFilter\Rule;

/**
 * An instance of RangeRule checks if a given number lies between an upper and lower bound
 *
 */
class RangeRule extends Rule
{

    /**
     * The lower bound
     *
     * @var mixed
     */
    private $min;

    /**
     * The upper bound
     *
     * @var mixed
     */
    private $max;

    public function __construct($min, $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * Check if $arg lies within the bounds
     *
     * @param mixed $arg
     * @return bool
     */
    public function check($arg)
    {
        if(!is_numeric($arg)) {
            return false;
        }
        return $this->checkMin($arg) && $this->checkMax($arg);
    }

    /**
     * Check if other is greater than or equal the minimum.
     * Return true, if the minimum is empty ('')
     *
     * @param $other
     * @return bool
     */
    protected function checkMin($other) {
        if($this->min === '') {
            return true;
        }
        return $other >= $this->min;
    }

    /**
     * Check if other is less than or equal the maximum.
     * Return true, if the maximum is empty ('')
     *
     * @param $other
     * @return bool
     */
    protected function checkMax($other) {
        if($this->max === '') {
            return true;
        }
        return $other <= $this->max;
    }

    public function contains(Rule $other) {
        if($other instanceof NoRule) {
            return true;
        }
        if($other instanceof NumberRule) {
            return $this->check($other->getNumber());
        }
        if($other instanceof static) {
            return $this->checkMin($other->min) && $this->checkMax($other->max);
        }
        return false;
    }

    /**
     * Return a string representation for the given instance
     *
     * @return string
     */
    public function __toString()
    {
        return $this->min.'-'.$this->max;
    }
}
