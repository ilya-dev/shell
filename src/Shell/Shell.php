<?php namespace Shell;

class Shell {

    /**
     * Elements of the chain
     *
     * @var array
     */
    protected $elements;

    /**
     * The ArgumentsParser instance
     *
     * @var \Shell\ArgumentsParser
     */
    protected $arguments;

    /**
     * The OptionsParser instance
     *
     * @var \Shell\OptionsParser
     */
    protected $options;

    /**
     * Constructor
     *
     * @param \Shell\ArgumentsParser $arguments
     * @param \Shell\OptionsParser   $options
     * @return void
     */
    public function __construct(ArgumentsParser $arguments, OptionsParser $options)
    {
        $this->arguments = $arguments;
        $this->options   = $options;
        $this->elements  = [];
    }

    /**
     * Add an element to the chain
     *
     * @param  dynamic
     * @return self
     */
    public function add()
    {
        list($command, $arguments, $options) = $this->group(\func_get_args());

        $arguments = $this->arguments->parse($arguments);
        $options   = $this->options->parse($options);
        $isEnd     = $this->hasPrefix('and', $command);

        if ($isEnd)
        {
            $command = $this->extractName($command);
        }

        $this->elements[] = \sprintf('%s %s %s', $command, $arguments, $options);

        if ($isEnd)
        {
            return $this->endChain();
        }
    }

    /**
     * Group given set of data to "command", "arguments" and "options"
     *
     * @param  array $data
     * @return array
     */
    protected function group(array $data)
    {
        $command   = $data[0];
        $arguments = $options = [];

        foreach (\array_slice($data, 1) as $element)
        {
            if (\is_array($element))
            {
                $options = \array_merge($element, $options);
            }
            else
            {
                $arguments[] = $element;
            }
        }

        return [$command, $arguments, $options];
    }

    /**
     * Extract the name of a command
     *
     * @param  string $command
     * @return string
     */
    protected function extractName($command)
    {
        return \lcfirst(\str_replace('and', '', $command));
    }

    /**
     * Determine whether a string has the given prefix
     *
     * @param  string  $prefix
     * @param  string  $string
     * @return boolean
     */
    protected function hasPrefix($prefix, $string)
    {
        return 0 === \strpos($string, $prefix);
    }

    /**
     * End the chain
     *
     * @return string
     */
    public function endChain()
    {
        $pipe = ' | ';

        return \implode($pipe, $this->elements);
    }

    /**
     * Start a new chain
     *
     * @param  string $command
     * @param  array  $arguments
     * @return \Shell\Shell
     */
    public static function startChain($command, array $arguments = array())
    {
        $instance = new static;

        \call_user_func_array([$instance, $command], $arguments);

        return $instance;
    }

    /**
     * Handle dynamic calls to the instance
     *
     * @param  string $method
     * @param  array  $arguments
     * @return self
     */
    public function __call($method, array $arguments)
    {
        $result = \call_user_func_array([$this, $method], $arguments);

        return $result ?: $this;
    }

    /**
     * Handle dynamic calls
     *
     * @param  string $method
     * @param  array  $arguments
     * @return \Shell\Shell
     */
    public static function __callStatic($method, array $arguments)
    {
        return static::startChain($method, $arguments);
    }

    /**
     * Treat the object as a string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->endChain();
    }

}

