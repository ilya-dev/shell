<?php namespace spec\Shell;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Shell\ArgumentsParser;

class ShellSpec extends ObjectBehavior {

    function let(ArgumentsParser $parser)
    {
        $this->beConstructedWith($parser);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Shell\Shell');
    }

    function it_builds_a_command_string_properly(ArgumentsParser $parser)
    {
        $parser->parse(Argument::any())->willReturn('wow');

        $this->add('foo-bar');
        $this->add('baz');

        $this->endChain()->shouldReturn('foo-bar wow | baz wow');
    }

}

