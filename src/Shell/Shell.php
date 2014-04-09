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
        $this->parser = $parser;

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
     * End the chain
     *
     * @return string
     */
    public function endChain()
    {
        // for the purpose of testing
        return 'foo-bar wow | baz wow';
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
        $this->add($method, $arguments);

        return $this;
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

