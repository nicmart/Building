<?php
/**
 * This file is part of DomainSpecificQuery
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Nicolò Martini <nicmartnic@gmail.com>
 */

namespace Building;

/**
 * Class AbstractBuilder
 * @package Building
 */
abstract class AbstractBuilder
{
    /** @var AbstractBuilder[] */
    protected $builders = array();

    /** @var array Context[] */
    protected $stack = array();

    /**
     * @param $name
     * @param AbstractBuilder $builder
     *
     * @return $this
     */
    public function registerBuilder($name, AbstractBuilder $builder)
    {
        $builder
            ->setStack($this->stack)
            ->setBuilders($this->builders)
        ;
        $this->builders[$name] = $builder;

        return $this;
    }

    /**
     * @param array $stack
     * @return $this
     */
    public function setStack(array &$stack)
    {
        $this->stack = &$stack;

        return $this;
    }

    /**
     * @param array $builders
     * @return $this
     */
    public function setBuilders(array &$builders)
    {
        $this->builders = &$builders;

        return $this;
    }

    /**
     * @param string $name
     * @param array $args
     * @return AbstractBuilder
     */
    public function build($name, array $args = array())
    {
        $builder = $this->builders[$name];

        return call_user_func_array(array($builder, 'processStart'), $args);
    }

    /**
     * @param $name
     * @param $args
     * @return AbstractBuilder
     */
    public function __call($name, $args)
    {
        return $this->build($name, $args);
    }

    /**
     * @see processEnd()
     * @return AbstractBuilder
     */
    public function end()
    {
        return $this->processEnd();
    }

    /**
     * Do initial part of building and return a builder
     *
     * @return AbstractBuilder
     */
    abstract function processStart();

    /**
     * Do object manipulation using context args.
     *
     * @return mixed
     */
    abstract function processArgs();

    /**
     * @return AbstractBuilder
     */
    public function processEnd()
    {
        $this->processArgs();
        array_pop($this->stack);

        return $this->context()->builder;
    }

    /**
     * @return mixed
     *
     * @throws EmptyStackException
     */
    public function get()
    {
        if ($this->isStackEmpty())
            throw new EmptyStackException('Builder stack is empty');

        $this->processArgs();

        return $this->context()->object;
    }

    /**
     * Return the current context
     *
     * @return Context
     * @throws EmptyStackException
     */
    protected function context()
    {
        if ($this->isStackEmpty())
            throw new EmptyStackException('Builder stack is empty');

        return $this->stack[count($this->stack) - 1];
    }

    /**
     * Add an argument to the current context
     *
     * @param $arg
     */
    protected function addArgument($arg)
    {
        if (!$this->isStackEmpty())
            $this->context()->arguments[] = $arg;
    }

    /**
     * @return bool
     */
    protected function isStackEmpty()
    {
        return !(bool) $this->stack;
    }
} 