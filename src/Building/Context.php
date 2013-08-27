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
     * @param mixed|null $object
     * @param BuildProcess $process
     */
    public function __construct(&$object = null, BuildProcess $process = null)
    {
        $this->object = &$object;
        $this->process = $process ?: new DummyProcess;
    }
} 