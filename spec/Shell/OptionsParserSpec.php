<?php namespace spec\Shell;

use PhpSpec\ObjectBehavior;

class OptionsParserSpec extends ObjectBehavior {

    function it_is_initializable()
    {
        $this->shouldHaveType('Shell\OptionsParser');
    }

    function it_transforms_an_array_of_options_to_a_string()
    {
        $options = ['foo' => 'bar', 'wow' => 'such'];

        $this->parse($options)->shouldReturn("--foo='bar' --wow='such'");
    }

    function it_works_with_flags()
    {
        $options = ['f' => 'bar', 'wow' => 'baz'];

        $this->parse($options)->shouldReturn("-f='bar' --wow='baz'");
    }

    function it_works_with_optional_values()
    {
        $options = ['b' => 'baz', 'f', 'amaze'];

        $this->parse($options)->shouldReturn("-b='baz' -f --amaze");
    }

}
