<?php

namespace spec\ELearningAG\ObjectFilter\Rules;

use ELearningAG\ObjectFilter\Rules\NoRule;
use ELearningAG\ObjectFilter\Rules\NumberRule;
use ELearningAG\ObjectFilter\Rules\RangeRule;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RangeRuleSpec extends ObjectBehavior
{
    function let() {
        $this->beConstructedWith(100, 300);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('ELearningAG\ObjectFilter\Rules\RangeRule');
    }

    function it_checks_if_integer_is_between_given_range() {
        $a = 101;
        $b = 99.3;
        $this->check($a)->shouldReturn(true);
        $this->check($b)->shouldReturn(false);
    }

    function it_fails_if_checked_argument_is_not_numeric() {
        $this->check('string')->shouldReturn(false);
        $this->check([1,2,3])->shouldReturn(false);
    }

    function it_has_an_implicit_default_value_for_min() {
        $this->beConstructedWith('', 30);
        $this->check(~PHP_INT_MAX)->shouldReturn(true);

        $this->__toString()->shouldReturn('-30');
    }

    function it_has_an_implicit_default_value_for_max() {
        $this->beConstructedWith(30, '');
        $this->check(PHP_INT_MAX)->shouldReturn(true);

        $this->__toString()->shouldReturn('30-');
        $this->toArray()->shouldReturn([30,'']);
    }

    function it_contains_smaller_ranges_and_numbers() {
        $other1 = new NumberRule(101);
        $other2 = new RangeRule(150, 200);
        $other3 = new RangeRule(99,199);
        $other4 = new NoRule();

        $this->contains($other1)->shouldReturn(true);
        $this->contains($other2)->shouldReturn(true);
        $this->contains($other3)->shouldReturn(false);
        $this->contains($other4)->shouldReturn(true);
    }
}
