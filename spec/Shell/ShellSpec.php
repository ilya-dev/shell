<?php namespace spec\Shell;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Shell\ArgumentsParser as Arguments;
use Shell\OptionsParser as Options;

class ShellSpec extends ObjectBehavior {

    function let(Arguments $arguments, Options $options)
    {
        $this->beConstructedWith($arguments, $options);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Shell\Shell');
    }

    function it_builds_a_command_string_properly(Arguments $parser)
    {
        $parser->parse(Argument::any())->willReturn('wow');

        $this->add('foo-bar');
        $this->add('baz');

        $this->endChain()->shouldReturn('foo-bar wow | baz wow');
    }

    function it_is_smart_enough_to_return_the_result_automatically(Arguments $parser)
    {
        $parser->parse(Argument::any())->willReturn('bar');

        $this->add('andFoo')->shouldReturn('foo bar');
    }

    function it_can_work_with_arguments(Arguments $arguments, Options $options)
    {
        $arguments->parse(['d'])->willReturn('-d');

        $options->parse(['bar', 'baz'])->willReturn("'bar' 'baz'");

        $this->add('foo', 'bar', 'baz', ['d']);

        $this->endChain()->shouldReturn("foo 'bar' 'baz' -d");
    }

}

