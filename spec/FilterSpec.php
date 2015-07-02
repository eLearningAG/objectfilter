<?php

namespace spec\ELearningAG\ObjectFilter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FilterSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(['price' => '30-40']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('ELearningAG\ObjectFilter\Filter');
    }

    function it_is_countable()
    {
        $this->shouldHaveType('\Countable');
        $this->count()->shouldReturn(1);
    }

    function it_takes_further_rules()
    {
        $count = $this->getWrappedObject()->count();
        $this->add('price', '10-20');
        $this->count()->shouldReturn($count + 1);
    }

    function it_check_its_rules()
    {
        $item1 = ['price' => 3, 'category' => 1];
        $item2 = ['price' => 35, 'category' => 1];
        $item3 = ['price' => 35, 'category' => 4];

        $this->apply($item1)->shouldReturn(false);
        $this->apply($item2)->shouldReturn(true);

        $this->add('category', 1);

        $this->apply($item1)->shouldReturn(false);

        $this->apply($item2)->shouldReturn(true);

        $this->apply($item3)->shouldReturn(false);
    }

    function it_has_a_string_representation()
    {

        $this->add('category', '1,2');

        $this->__toString()->shouldReturn('filter[price]=30-40&filter[category]=1,2');

    }

    function it_treats_missing_attributes()
    {

        $item = [];

        $this->apply($item)->shouldReturn(false);

    }

    function it_is_invokable()
    {
        $this([])->shouldReturn(false);
    }

    function it_has_a_factory_method()
    {
        $instance = $this::create(['price' => '1-10', 'category' => 4]);
        $instance->shouldHaveType('ELearningAG\ObjectFilter\Filter');
        $instance->count()->shouldReturn(2);
        $instance->apply(['price' => 5, 'category' => 4])->shouldReturn(true);
        $instance->apply(['price' => 5, 'category' => 13])->shouldReturn(false);
    }

    function it_can_be_created_from_a_query_string()
    {

        $query = 'filter[price]=30-40&filter[category]=1,2';

        $instance = $this::createFromQueryString($query);

        $instance->shouldHaveType('ELearningAG\ObjectFilter\Filter');

        $instance->count()->shouldReturn(2);

        $instance->apply(['price' => 34, 'category' => 1])->shouldReturn(true);
        $instance->apply(['price' => 39, 'category' => 2])->shouldReturn(true);
        $instance->apply(['price' => 41, 'category' => 2])->shouldReturn(false);

        $instance->__toString()->shouldReturn($query);

        $query2 = 'lang=en&' . $query . '&q=word';

        $this::createFromQueryString($query2)->__toString()->shouldReturn($query);


    }

    function it_is_always_satisfied_if_empty() {
        $query3 = '';

        $instance = $this::createFromQueryString($query3);
        $instance->__toString()->shouldReturn('');

        $instance->apply(null)->shouldReturn(true);
    }

    function it_can_tell_if_a_rule_exists()
    {
        $this->hasRule('price', '30-40')->shouldReturn(true);
        $this->hasRule('category', 1)->shouldReturn(false);

        $this->add('category', '1,2,3');
        $this->hasRule('category', '1,2,3')->shouldReturn(true);

        $instance = $this::createFromQueryString('filter[price]=0-20,20-50');
        $instance->hasRule('price', '0-20')->shouldReturn(true);
    }
}
