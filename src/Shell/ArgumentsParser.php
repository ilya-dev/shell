<?php namespace Shell;

class ArgumentsParser {

    /**
     * Transform an array of arguments to a string
     *
     * @param  array  $arguments
     * @return string
     */
    public function parse(array $arguments)
    {
        $arguments = \array_map('\\escapeshellarg', $arguments);

        return \implode(' ', $arguments);
    }

}

