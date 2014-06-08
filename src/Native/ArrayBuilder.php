<?php
/**
 * This file is part of library-template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Nicolò Martini <nicmartnic@gmail.com>
 */

namespace NicMart\Building\Native;

use NicMart\Building\AbstractBuilder;

class ArrayBuilder extends AbstractBuilder
{
    /**
     * @param callable $callback
     * @param array $building
     */
    public function __construct(callable $callback = null, array $building = [])
    {
        return parent::__construct($callback, $building);
    }

    /**
     * @param mixed $value
     *
     * @return $this|ValueBuilder
     */
    public function push($value = null)
    {
        if (isset($value)) {
            $this->building[] = $value;
            return $this;
        }

        return new ValueBuilder($this->getPushCallback());
    }

    /**
     * @param string|int $key
     * @param mixed $value
     *
     * @return $this|ValueBuilder
     */
    public function set($key, $value = null)
    {
        if (isset($value)) {
            $this->building[$key] = $value;
            return $this;
        }

        return new ValueBuilder($this->getSetCallback($key));
    }

    private function getPushCallback()
    {
        return function($val) {
            $this->building[] = $val;
            return $this;
        };
    }

    private function getSetCallback($key)
    {
        return function($val) use ($key) {
            $this->building[$key] = $val;
            return $this;
        };
    }
} 