<?php namespace Shell;

class ArgumentBuilder extends Builder {

    /**
     * Build a string from an array of arguments.
     *
     * @param array $arguments
     * @return string
     */
    public function build(array $arguments)
    {
        return implode(' ', array_map('escapeshellarg', $arguments));
    }

}
