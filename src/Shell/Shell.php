<?php namespace Shell;

class Shell {

    /**
     * The elements of the current chain.
     *
     * @var array
     */
    protected $elements = [];

    /**
     * The ArgumentBuilder instance.
     *
     * @var ArgumentBuilder
     */
    protected $arguments;

    /**
     * The OptionBuilder instance.
     *
     * @var OptionBuilder
     */
    protected $options;

    /**
     * The constructor.
     *
     * @param ArgumentBuilder|null $argument
     * @param OptionBuilder|null $option
     * @return Shell
     */
    public function __construct(ArgumentBuilder $argument = null, OptionBuilder $option = null)
    {
        $this->argument = $argument ?: new ArgumentBuilder;
        $this->option = $option ?: new OptionBuilder;
    }

    /**
     * Add an element to the chain.
     *
     * @param dynamic
     * @return self
     */
    public function add()
    {
        list ($command, $arguments, $options) = $this->group(func_get_args());

        $arguments = $this->argument->build($arguments);
        $options = $this->option->build($options);
        $isEnd = $this->hasPrefix('and', $command);

        if ($isEnd)
        {
            $command = $this->extractName($command);
        }

        $this->elements[] = sprintf('%s %s %s', $command, $arguments, $options);

        if ($isEnd)
        {
            return $this->endChain();
        }
    }

    /**
     * Group a given array by "command", "arguments" and "options".
     *
     * @param array $data
     * @return array
     */
    protected function group(array $data)
    {
        $command = reset($data);
        $arguments = [];
        $options = [];

        foreach (array_slice($data, 1) as $element)
        {
            if (is_array($element))
            {
                $options = array_merge($element, $options);

                continue;
            }

            $arguments[] = $element;
        }

        return [$command, $arguments, $options];
    }

    /**
     * Extract name of a given command.
     *
     * @param string $command
     * @return string
     */
    protected function extractName($command)
    {
        return lcfirst(str_replace('and', '', $command));
    }

    /**
     * Determine whether a given string has a prefix.
     *
     * @param string $prefix
     * @param string $string
     * @return boolean
     */
    protected function hasPrefix($prefix, $string)
    {
        return strpos($string, $prefix) === 0;
    }

    /**
     * End the current chain.
     *
     * @return string
     */
    public function endChain()
    {
        return implode(' | ', $this->elements);
    }

    /**
     * Start a new chain.
     *
     * @param string $command
     * @param array $arguments
     * @return Shell
     */
    public static function startChain($command, array $arguments = [])
    {
        $instance = new static;

        call_user_func_array([$instance, $command], $arguments);

        return $instance;
    }

    /**
     * Handle calls to non-existent methods.
     *
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public function __call($method, array $arguments)
    {
        array_unshift($arguments, $method);

        return call_user_func_array([$this, 'add'], $arguments) ?: $this;
    }

    /**
     * Handle static calls to non-existent methods.
     *
     * @param string $method
     * @param array $arguments
     * @return Shell
     */
    public static function __callStatic($method, array $arguments)
    {
        return static::startChain($method, $arguments);
    }

    /**
     * Convert the object into a string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->endChain();
    }

}
