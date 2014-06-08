<?php
/**
 * This file is part of library-template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Nicolò Martini <nicmartnic@gmail.com>
 */

namespace NicMart\Building;

/**
 * Class AbstractBuilder
 *
 * @package NicMart\Building
 */
abstract class AbstractBuilder implements Builder
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * @var mixed
     */
    protected $building;

    /**
     * @param callable $callback
     * @param mixed $building
     */
    public function __construct(callable $callback = null, $building = null)
    {
        if (!isset($callback))
            $callback = function($x) { return $x; };

        $this->callback = $callback;
        $this->building = $building;
    }

    /**
     * {@inheritdoc}
     */
    public function end()
    {
        $callback = $this->callback;

        return $callback($this->building);
    }

    /**
     * {@inheritdoc}
     */
    public function setCallback(callable $callback)
    {
        $this->callback = $callback;

        return $this;
    }
}