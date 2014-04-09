<?php namespace Shell;

class Shell {

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

