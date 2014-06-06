<?php namespace Shell;

class OptionsParser {

    /**
     * Transform an array of options to a string.
     *
     * @param array $options
     * @return string
     */
    public function parse(array $options)
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
