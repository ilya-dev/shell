<?php namespace spec\Shell;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class OptionsParserSpec extends ObjectBehavior {

    function it_is_initializable()
    {
        $this->shouldHaveType('Shell\OptionsParser');
    }

    function it_transforms_an_array_of_options_to_a_string()
    {
        $options = [
            'foo' => 'bar',
            'wow' => 'such',
        ];

        $this->parse($options)->shouldReturn("--foo='bar' --wow='such'");
    }

    function it_knows_how_to_work_with_flags()
    {
        $options = [
            'f'   => 'bar',
            'wow' => 'baz',
        ];

        $this->parse($options)->shouldReturn("-f='bar' --wow='baz'");
    }

    function it_knows_that_an_option_can_have_no_value()
    {
        $options = [
            'b' => 'baz',
            'f',
            'amaze',
        ];

        $this->parse($options)->shouldReturn("-b='baz' -f --amaze");
    }

}

