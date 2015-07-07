<?php

namespace spec\ELearningAG\ObjectFilter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RuleSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf('ELearningAG\ObjectFilter\Rules\RangeRule');
        $this->beConstructedWith(10, 30);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('ELearningAG\ObjectFilter\Rule');
    }

    function it_check_its_compliance() {
        $this->check(25)->shouldReturn(true);
        $this->check(35)->shouldReturn(false);
    }

    function it_provides_a_factory_method() {
        $this::create('10-30')->shouldHaveType('ELearningAG\ObjectFilter\Rules\RangeRule');

        $this::create('-30')->shouldHaveType('ELearningAG\ObjectFilter\Rules\RangeRule');

        $this::create('10-')->shouldHaveType('ELearningAG\ObjectFilter\Rules\RangeRule');

        $this::create(null)->shouldHaveType('ELearningAG\ObjectFilter\Rules\NoRule');

        $this::create('')->shouldHaveType('ELearningAG\ObjectFilter\Rules\NoRule');
    }
}
