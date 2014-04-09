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
            if (\is_string($key))
            {
                if (\strlen($key) == 1)
                {
                    $piece = '-'.$key;
                }
                else
                {
                    $piece = '--'.$key;
                }
            }

            if ( ! \is_int($key))
            {
                $piece .= '='.\escapeshellarg($value);
            }
            else
            {
                $piece = '-'.$value;
            }

            $pieces[] = $piece;
        }

        return \implode(' ', $pieces);
    }

}

