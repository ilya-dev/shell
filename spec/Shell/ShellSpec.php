<?php namespace spec\Shell;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ShellSpec extends ObjectBehavior {

    function let(\Shell\ArgumentsParser $parser)
    {
        $this->beConstructedWith($parser);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Shell\Shell');
    }

}

