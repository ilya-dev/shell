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
        $arguments = [
            'foo' => 'bar',
            'wow' => 'such',
        ];

        $this->parse($arguments)->shouldReturn("--foo='bar' --wow='such'");
    }

    function it_knows_the_difference_between_flags_and_arguments()
    {
        $arguments = [
            'f'   => 'bar',
            'wow' => 'baz',
        ];

        $this->parse($arguments)->shouldReturn("-f='bar' --wow='baz'");
    }

    function it_knows_that_an_argument_can_have_no_value()
    {
        $arguments = [
            'b' => 'baz',
            'f',
            'amaze',
        ];

        $this->parse($arguments)->shouldReturn("-b='baz' -f --amaze");
    }

}

