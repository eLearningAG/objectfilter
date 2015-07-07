<?php

namespace ELearningAG\ObjectFilter;

use ELearningAG\ObjectFilter\Rules\NoRule;
use ELearningAG\ObjectFilter\Rules\NumberRule;
use ELearningAG\ObjectFilter\Rules\OrRule;
use ELearningAG\ObjectFilter\Rules\RangeRule;

abstract class Rule
{
    /**
     * Check if the given argument complies to the given rule
     *
     * @param $arg
     * @return mixed
     */
    abstract public function check($arg);

    /**
     * Check if another rule is contained within this rule
     *
     * @param Rule $other
     * @return mixed
     */
    abstract public function contains(Rule $other);

    /**
     * @return string
     */
    abstract public function __toString();

    /**
     * A factory method that tries to create the correct concrete rule implementation for
     * a given string representation. The following rules are available:
     *
     * - NoRule: This rule is always satisfied
     * - RangeRule: Checks if a number lies between an upper and a lower bound
     * - NumberRule: check if a the argument is equal to a certain number
     * - OrRule: Check if the argument is contained in a list of rules
     *
     * @param $rule
     * @return OrRule|RangeRule
     */
    public static function create($rule)
    {
        if(empty($rule)) {
            return new NoRule();
        }

        if (preg_match('/^(\d*)$/', $rule, $matches)) {
            return new NumberRule($matches[1]);
        }
        if (preg_match('/^(\d*)-(\d*)$/', $rule, $matches)) {
            return new RangeRule($matches[1], $matches[2]);
        }

        return new OrRule($rule);
    }
}
