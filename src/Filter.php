<?php

namespace ELearningAG\ObjectFilter;

/**
 * If applied an instance of this Filter class checks if the attributes of a given object
 * comply to a set of rules.
 *
 */
class Filter implements \Countable
{
    /**
     * The rules checked by this filter instance
     *
     * @var array
     */
    protected $rules = [];

    /**
     * The last rule that failed
     *
     * @var Rule
     */
    protected $failedRule = null;

    /**
     * Number of rules
     *
     * @var int
     */
    protected $count = 0;

    /**
     * Create a new filter instance. An initial set of rules can be provided as parameter
     *
     * @param array $rules
     */
    public function __construct(array $rules = [])
    {
        foreach ($rules as $attribute => $rule) {
            $this->add($attribute, $rule);
        }
    }

    /**
     * Create a new filter instance from an array or string.
     *
     * @param array|string $rules
     * @return Filter
     */
    public static function create($rules)
    {

        if (is_array($rules)) {
            return new static($rules);
        }
        if (is_string($rules)) {
            return static::createFromQueryString($rules);
        }
    }

    /**
     * Create a new filter instance from a query string
     *
     * @param $string
     * @return static
     */
    public static function createFromQueryString($string)
    {

        $query = [];
        parse_str($string, $query);

        if(isset($query['filter'])) {
            return new static($query['filter']);
        }
        return new static();
    }

    /**
     * Count the number of rules in this filter
     *
     * @return int
     */
    public function count()
    {
        return $this->count;
    }

    /**
     * Add a new rule for the given attribute
     *
     * @param $attribute
     * @param $rule
     * @return $this
     *
     */
    public function add($attribute, $rule)
    {
        $this->count++;
        $this->rules[$attribute][] = Rule::create($rule);
        return $this;
    }


    /**
     * Internal function to retrieve the value from $item for $attribute and check
     * if the given rule complies.
     *
     * Return false, if the $item does not have an property $attribute
     *
     * @param Rule $rule
     * @param $item
     * @param $attribute
     * @return bool
     */
    protected function check_attribute(Rule $rule, $item, $attribute)
    {
        $value = null;
        if (is_object($item) && isset($item->$attribute)) {
            $value = $item->$attribute;
        }
        if (is_array($item) && isset($item[$attribute])) {
            $value = $item[$attribute];
        }

        if ($value === null || !$rule->check($value)) {
            $this->failedRule = $rule;
            return false;
        }

        return true;
    }

    /**
     * Iterate over all rules and check if $item complies to them
     *
     * @param $item
     * @return bool
     */
    public function apply($item)
    {
        foreach ($this->rules as $attribute => $rules) {
            foreach ($rules as $rule) {
                if (!$this->check_attribute($rule, $item, $attribute)) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Return the last failed rule
     *
     * @return Rule
     */
    public function getLastFailedRule()
    {
        return $this->failedRule;
    }

    /**
     * Invoke the filter as function. Calls the apply method.
     *
     * @param $target
     * @return bool
     */
    public function __invoke($target)
    {
        return $this->apply($target);
    }

    /**
     * Returns a (query) string representation for the filter instance
     *
     * @return string
     */
    public function __toString()
    {
        $r = [];
        foreach ($this->rules as $attribute => $rules) {
            $str = "filter[${attribute}]=";
            $s = [];
            foreach ($rules as $rule) {
                $s[] = $rule->__toString();
            }
            $r[] = $str . implode(',', $s);
        }
        return implode('&', $r);
    }

    /**
     * Check if the requested rule is already contained.
     *
     * @param $attribute
     * @param $rule
     * @return bool
     */
    public function hasRule($attribute, $rule)
    {
        if (!isset($this->rules[$attribute])) {
            return false;
        }
        $rule = Rule::create($rule);

        foreach ($this->rules[$attribute] as $other) {
            if ($other->contains($rule)) {
                return true;
            }
        }
        return false;
    }
}
