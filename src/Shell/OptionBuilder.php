<?php namespace Shell;

class OptionBuilder extends Builder {

    /**
     * Build a string from an array of options.
     *
     * @param array $options
     * @return string
     */
    public function build(array $options)
    {
        $chunks = [];

        foreach ($options as $key => $value)
        {
            if (is_int($key))
            {
                $chunks[] = sprintf('%s%s', $this->prefix($value), $value);

                continue;
            }

            $chunks[] = sprintf(
                '%s%s=%s', $this->prefix($key), $key, escapeshellarg($value)
            );
        }

        return implode(' ', $chunks);
    }

    /**
     * Get an appropriate prefix for a given string.
     *
     * @param string $string
     * @return string
     */
    protected function prefix($string)
    {
        return strlen($string) == 1 ? '-' : '--';
    }

}
