<?php

namespace spec\ELearningAG\ObjectFilter\Rules;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use ELearningAG\ObjectFilter\Rules\NumberRule;
use ELearningAG\ObjectFilter\Rules\RangeRule;

class OrRuleSpec extends ObjectBehavior
{
    function let() {
        $this->beConstructedWith(new NumberRule(1), 2, new RangeRule(20,30));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('ELearningAG\ObjectFilter\Rules\OrRule');
        $this->shouldHaveType('ELearningAG\ObjectFilter\Rule');
    }

    function it_checks_if_value_is_contained_in_list() {
        $this->check(1)->shouldReturn(true);
        $this->check(2)->shouldReturn(true);
        $this->check(4)->shouldReturn(false);
        $this->check(24)->shouldReturn(true);
    }

    function it_is_satisfied_if_no_rule_is_attached() {
        $this->beConstructedWith();

        $this->check(4)->shouldReturn(true);
    }
}

