<?php namespace spec\Shell;

use PhpSpec\ObjectBehavior;

class OptionBuilderSpec extends ObjectBehavior {

    function it_is_initializable()
    {
        $this->shouldHaveType('Shell\OptionBuilder');
    }

    function it_builds_a_string_from_an_array_of_options_1()
    {
        $options = ['foo' => 'bar', 'wow' => 'such'];

        $this->build($options)->shouldReturn("--foo='bar' --wow='such'");
    }

    function it_builds_a_string_from_an_array_of_options_2()
    {
        $options = ['f' => 'bar', 'wow' => 'baz'];

        $this->build($options)->shouldReturn("-f='bar' --wow='baz'");
    }

    function it_builds_a_string_from_an_array_of_options_3()
    {
        $options = ['b' => 'baz', 'f', 'amaze'];

        $this->build($options)->shouldReturn("-b='baz' -f --amaze");
    }

}
