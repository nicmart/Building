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
 * Class Builder
 * @package Building
 */
class Builder
{
    /** @var BuildProcess[] */
    private $processes = array();

    /** @var array Context[] */
    private $stack = array();

    /**
     * @param Context $context
     */
    public function __construct(Context $context = null)
    {
        if (!isset($context))
            $context = new Context;

        $this->stack[] = $context;
    }

    /**
     * @param $name
     * @param BuildProcess $builder
     *
     * @return $this
     */
    public function registerProcess($name, BuildProcess $builder)
    {
        $this->processes[$name] = $builder;

        return $this;
    }

    /**
     * @return array|BuildProcess[]
     */
    public function getProcesses()
    {
        return $this->processes;
    }

    /**
     * @param string $name
     * @param array $args
     * @return Builder
     */
    public function build($name, array $args = array())
    {
        $process = $this->processes[$name];
        array_unshift($args, $this->context());

        if ($context = call_user_func_array(array($process, 'build'), $args)) {
            $this->stack[] = $context;
        }

        return $this;
    }

    /**
     * @param $name
     * @param $args
     * @return Builder
     */
    public function __call($name, $args)
    {
        return $this->build($name, $args);
    }

    /**
     * @see processEnd()
     * @return Builder
     */
    public function end()
    {
        $this->context()->process->finalize($this->context());

        array_pop($this->stack);

        return $this;
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

        return $this->context()->object;
    }

    /**
     * Return the current context
     *
     * @return Context
     * @throws EmptyStackException
     */
    private function context()
    {
        if ($this->isStackEmpty())
            throw new EmptyStackException('Builder stack is empty');

        return $this->stack[count($this->stack) - 1];
    }

    /**
     * @return bool
     */
    private function isStackEmpty()
    {
        return !(bool) $this->stack;
    }
} 