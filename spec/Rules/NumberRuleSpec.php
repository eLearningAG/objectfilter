<?php

namespace spec\ELearningAG\ObjectFilter\Rules;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NumberRuleSpec extends ObjectBehavior
{
    function let() {
        $this->beConstructedWith(1);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('ELearningAG\ObjectFilter\Rules\NumberRule');
        $this->shouldHaveType('ELearningAG\ObjectFilter\Rule');
    }

    function it_checks_if_the_value_is_equal_to_its_number() {
        $this->check(1)->shouldReturn(true);
        $this->check(4)->shouldReturn(false);
    }

    function it_checks_object_ids() {
        $this->check((object)['id' => 1])->shouldReturn(true);
    }
}
