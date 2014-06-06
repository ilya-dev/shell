<?php namespace spec\Shell;

use PhpSpec\ObjectBehavior;

class ArgumentBuilderSpec extends ObjectBehavior {

    function it_is_initializable()
    {
        $this->shouldHaveType('Shell\ArgumentBuilder');
    }

    function it_builds_a_string_from_an_array_of_arguments()
    {
        $this->build(['foo', 'bar'])->shouldReturn("'foo' 'bar'");
    }

}
