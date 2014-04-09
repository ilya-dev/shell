<?php namespace Shell;

class OptionsParser {

    /**
     * Transform an array of options to a string
     *
     * @param  array  $options
     * @return string
     */
    public function parse(array $options)
    {
        $pieces = [];

        foreach ($options as $key => $value)
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

