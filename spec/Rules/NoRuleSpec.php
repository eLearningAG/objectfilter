<?php

namespace spec\ELearningAG\ObjectFilter\Rules;

use ELearningAG\ObjectFilter\Rules\NoRule;
use ELearningAG\ObjectFilter\Rules\NumberRule;
use ELearningAG\ObjectFilter\Rules\OrRule;
use ELearningAG\ObjectFilter\Rules\RangeRule;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NoRuleSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->shouldHaveType('ELearningAG\ObjectFilter\Rules\NoRule');
        $this->shouldHaveType('ELearningAG\ObjectFilter\Rule');
    }

    function it_is_always_satisfied() {
        $this->check(null)->shouldReturn(true);
        $this->check(false)->shouldReturn(true);
    }


    function it_contains_no_other_rule() {
        $other1 = new NumberRule(1);
        $other2 = new RangeRule(1,2);
        $other3 = new OrRule(new NumberRule(4), new RangeRule(3,4));

        $this->contains($other1)->shouldReturn(false);
        $this->contains($other2)->shouldReturn(false);
        $this->contains($other3)->shouldReturn(false);
    }

    function it_contains_only_itself() {
        $other1 = new NoRule();

        $this->contains($other1)->shouldReturn(true);
    }
}
