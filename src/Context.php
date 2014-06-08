<?php
/**
 * This file is part of DomainSpecificQuery
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Nicolò Martini <nicmartnic@gmail.com>
 */

namespace NicMart\Building;

/**
 * Class Context.
 * This class encapsulate the current state of a building process.
 *
 * @package Building
 */
class Context
{
    /** @var  mixed */
    public $object;

    /** @var BuildProcess  */
    public $process;

    /**
     * @var string
     */
    public $name;

    /**
     * @var Context
     */
    public $previous;

    /**
     * @param null|Context $previous
     * @param mixed|null $object
     * @param BuildProcess $process
     * @param string $name
     */
    public function __construct(Context $previous = null, $object = null, BuildProcess $process = null, $name = '')
    {
        $this->object = $object;
        $this->process = $process ?: new DummyProcess;
        $this->name = $name;
        $this->previous = $previous ?: $this;
    }

    /**
     * @return $this The current instance
     */
    public function notifyParent()
    {
        $this->previous->process->subvalueBuilded(
            $this->previous,
            $this->object
        );

        return $this;
    }
} 