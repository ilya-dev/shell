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
            // if the argument has no value,
            // we can just prepend a dash
            // and be done
            if (\is_int($key))
            {
                $pieces[] = '-'.$value;

                continue;
            }

            // otherwise,
            // we need to determine whether it's a flag
            // or a "true argument" and prefix the value correctly
            $prefix = (\strlen($key) == 1) ? '-' : '--';

            // always 'escape' values
            $value = \escapeshellarg($value);

            $pieces[] = \sprintf('%s%s=%s', $prefix, $key, $value);
        }

        return \implode(' ', $pieces);
    }

}

