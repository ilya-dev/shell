<?php namespace spec\Shell;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Shell\ArgumentsParser as Parser;

class ShellSpec extends ObjectBehavior {

    function let(Parser $parser)
    {
        $this->beConstructedWith($parser);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Shell\Shell');
    }

    function it_builds_a_command_string_properly(Parser $parser)
    {
        $parser->parse(Argument::any())->willReturn('wow');

        $this->add('foo-bar');
        $this->add('baz');

        $this->endChain()->shouldReturn('foo-bar wow | baz wow');
    }

    function it_is_smart_enough_to_return_the_result_automatically(Parser $parser)
    {
        $parser->parse(Argument::any())->willReturn('bar');

        $this->add('andFoo')->shouldReturn('foo bar');
    }

    function it_can_work_with_arguments(Parser $parser)
    {
        $parser->parse(['d'])->willReturn('-d');

        $this->add('foo', 'bar', 'baz', ['d']);

        $this->endChain()->shouldReturn("foo 'bar' 'baz' -d");
    }

}

