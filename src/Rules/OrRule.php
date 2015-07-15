<?php

namespace ELearningAG\ObjectFilter\Rules;

use ELearningAG\ObjectFilter\Rule;

/**
 * An instance of OrRule checks if a given argument satisfies at least one sub rule.
 */
class OrRule extends Rule
{

    /**
     * The list of rules
     *
     * @var array
     */
    private $list;

    /**
     * Create a new instance
     */
    public function __construct()
    {
        $this->list = [];

        foreach (func_get_args() as $arg) {
            $this->add($arg);
        }
    }

    /**
     * Add a rule
     *
     * @param mixed $rule
     */
    protected function add($rule)
    {
        if (is_array($rule)) {
            foreach ($rule as $subrule) {
                $this->add($subrule);
            }
            return;
        }
        if ($rule instanceof Rule) {
            $this->list[] = $rule;
        }
        if (is_numeric($rule)) {
            $this->list[] = new NumberRule($rule);
        }
        if (is_string($rule)) {
            foreach (explode(',', $rule) as $subrule) {
                $this->list[] = Rule::create(trim($subrule));
            }
        }
    }

    /**
     * Check if $arg satisfies at least one rule
     *
     * @param $arg
     * @return bool
     */
    public function check($arg)
    {
        foreach ($this->list as $rule) {
            if ($rule->check($arg)) {
                return true;
            }
        }
        return empty($this->list);
    }

    public function contains(Rule $other)
    {

        if ($other instanceof OrRule) {
            foreach ($other->list as $subOther) {
                if(!$this->contains($subOther)) {
                    return false;
                }
            }
            return true;
        }

        foreach ($this->list as $rule) {
            if ($rule->contains($other)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Return a string representation for the OrRule instance
     *
     * @return string
     */
    public function __toString()
    {
        $r = [];
        foreach ($this->list as $rule) {
            $r[] = $rule->__toString();
        }
        return implode(',', $r);
    }

    /**
     * Return an array representation for the NoRule instance
     *
     * @return array
     */
    public function toArray()
    {
        $r = [];
        foreach($this->list as $rule) {
            $r[] = $rule->toArray();
        }
        return $r;
    }
}
