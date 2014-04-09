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
        $pieces = [];

        foreach ($arguments as $key => $value)
        {
            if (\is_int($key))
            {
                $pieces[] = \sprintf('%s%s', $this->prefix($value), $value);

                continue;
            }

            $value = \escapeshellarg($value);

            $pieces[] = \sprintf('%s%s=%s', $this->prefix($key), $key, $value);
        }

        return \implode(' ', $pieces);
    }

    /**
     * Prefix a string properly
     *
     * @param  string $string
     * @return string
     */
    protected function prefix($string)
    {
        return \strlen($string) == 1 ? '-' : '--';
    }

}

