<?php namespace Shell;

class ArgumentsParser {

    /**
     * Transform an array of arguments to a string.
     *
     * @param array $arguments
     * @return string
     */
    public function parse(array $arguments)
    {
        return implode(' ', array_map('escapeshellarg', $arguments));
    }

}
