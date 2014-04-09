<?php namespace spec\Shell;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ArgumentsParserSpec extends ObjectBehavior {

    function it_is_initializable()
    {
        $this->shouldHaveType('Shell\ArgumentsParser');
    }

    function it_transforms_an_array_of_arguments_to_a_string()
    {
        $this->parse(['foo', 'bar'])->shouldReturn("'foo' 'bar'");
    }

}

