<?php namespace spec\Shell;

use PhpSpec\ObjectBehavior;
use Shell\Shell, Shell\ArgumentBuilder, Shell\OptionBuilder;

class ShellSpec extends ObjectBehavior {

    function let(ArgumentBuilder $argument, OptionBuilder $option)
    {
        $this->beConstructedWith($argument, $option);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Shell\Shell');
    }

    function it_builds_a_command_string_properly(Arguments $arguments, Options $options)
    {
        $arguments->parse(Argument::any())->willReturn('wow');
        $options->parse(Argument::any())->willReturn('so');

        $this->add('foo-bar');
        $this->add('baz');

        $this->endChain()->shouldReturn('foo-bar wow so | baz wow so');
    }

    function it_is_smart_enough_to_return_the_result_automatically(
        Arguments $arguments, Options $options)
    {
        $arguments->parse(Argument::any())->willReturn('bar');
        $options->parse(Argument::any())->willReturn('baz');

        $this->add('andFoo')->shouldReturn('foo bar baz');
    }

    function it_can_work_with_arguments(Arguments $arguments, Options $options)
    {
        $options->parse(['d'])->willReturn('-d');

        $arguments->parse(['bar', 'baz'])->willReturn("'bar' 'baz'");

        $this->add('foo', 'bar', 'baz', ['d']);

        $this->endChain()->shouldReturn("foo 'bar' 'baz' -d");
    }

    function it_provides_you_some_syntactic_sugar()
    {
        $this->add('andFoo')
             ->shouldBe(Shell::startChain('foo')->endChain());

        $this->endChain()->shouldBe(Shell::foo()->endChain());
    }

    function it_can_be_treated_as_a_string()
    {
        $this->add('ls');

        $this->endChain()->shouldBe((string) Shell::ls());
    }

}

