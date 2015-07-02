<?php

namespace spec\ELearningAG\ObjectFilter\Rules;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use ELearningAG\ObjectFilter\Rules\NumberRule;
use ELearningAG\ObjectFilter\Rules\RangeRule;
use ELearningAG\ObjectFilter\Rules\OrRule;

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

    function it_contains_other_rules() {
        $other1 = new NumberRule(2);
        $other2 = new RangeRule(21,29);
        $other3 = new NumberRule(14);

        $this->contains($other1)->shouldReturn(true);
        $this->contains($other2)->shouldReturn(true);
        $this->contains($other3)->shouldReturn(false);
    }

    function it_contains_other_or_rules() {
        $other1 = new OrRule(1,2);
        $other2 = new OrRule(1,2,3);
        $other3 = new OrRule(1,21,new RangeRule(23,25));
        $other4 = new OrRule(1,21,new RangeRule(23,31));

        $this->contains($other1)->shouldReturn(true);
        $this->contains($other2)->shouldReturn(false);
        $this->contains($other3)->shouldReturn(true);
        $this->contains($other4)->shouldReturn(false);
    }
}

