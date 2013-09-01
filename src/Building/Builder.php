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

    /** @var  Context */
    private $context;

    /**
     * @param Context $context
     */
    public function __construct(Context $context = null)
    {
        if (!isset($context))
            $context = new Context;

        $this->context = $context;
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
        $this->context->name = $name;

        //Avoid a bit of call_user_func_array overhead
        //See for example https://wiki.php.net/rfc/argument_unpacking and
        //https://gist.github.com/nikic/6390366
        switch (count($args)) {
            case 0: $context = $process->build($this->context); break;
            case 1: $context = $process->build($this->context, $args[0]); break;
            case 2: $context = $process->build($this->context, $args[0], $args[1]); break;
            case 3: $context = $process->build($this->context, $args[0], $args[1], $args[2]); break;
            case 4: $context = $process->build($this->context, $args[0], $args[1], $args[2], $args[3]); break;
            case 5: $context = $process->build($this->context, $args[0], $args[1], $args[2], $args[3], $args[4]); break;
            default:
                array_unshift($args, $this->context);
                $context = call_user_func_array(array($process, 'build'), $args);
        }

        if ($context)
            $this->context = $context;

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
        $this->context->process->finalize($this->context);
        $this->context = $this->context->previous;

        return $this;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->context->object;
    }
} 