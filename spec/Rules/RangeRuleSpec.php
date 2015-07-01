<?php

namespace spec\ELearningAG\ObjectFilter\Rules;

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
    }
}
