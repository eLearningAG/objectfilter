<?php

namespace spec\ELearningAG\ObjectFilter\Rules;

use ELearningAG\ObjectFilter\Rules\NoRule;
use ELearningAG\ObjectFilter\Rules\NumberRule;
use ELearningAG\ObjectFilter\Rules\RangeRule;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NumberRuleSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(1);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('ELearningAG\ObjectFilter\Rules\NumberRule');
        $this->shouldHaveType('ELearningAG\ObjectFilter\Rule');
    }

    function it_checks_if_the_value_is_equal_to_its_number()
    {
        $this->check(1)->shouldReturn(true);
        $this->check(4)->shouldReturn(false);
    }

    function it_checks_object_ids()
    {
        $this->check((object)['id' => 1])->shouldReturn(true);
    }

    function it_checks_arrays()
    {
        $this->check([1, 2, 3])->shouldReturn(true);

        $this->check([
            (object)[
                'id' => 1
            ],
            (object)[
                'id' => 2
            ]
        ])->shouldReturn(true);
    }


    function it_contains_only_other_number_rules()
    {
        $other1 = new NumberRule(1);
        $other2 = new NumberRule(3);
        $other3 = new RangeRule(1, 2);
        $other4 = new NoRule();

        $this->contains($other1)->shouldReturn(true);
        $this->contains($other2)->shouldReturn(false);
        $this->contains($other3)->shouldReturn(false);
        $this->contains($other4)->shouldReturn(true);
    }
}
