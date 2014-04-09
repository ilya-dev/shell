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
    protected $parser;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct(ArgumentsParser $parser)
    {
        $this->parser   = $parser;
        $this->elements = [];
    }

    /**
     * Add an element to the chain
     *
     * @param  string $command
     * @param  array  $arguments
     * @return self
     */
    public function add($command, array $arguments = array())
    {
        $arguments = $this->parser->parse($arguments);
        $isEnd     = $this->hasPrefix('and', $command);

        if ($isEnd)
        {
            $command = $this->extractName($command);
        }

        $this->elements[] = \sprintf('%s %s', $command, $arguments);

        if ($isEnd)
        {
            return $this->endChain();
        }
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

        $instance->add($command, $arguments);

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
        $result = $this->add($method, $arguments);

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

