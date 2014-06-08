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

class ValueBuilder extends AbstractBuilder
{
    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function set($value)
    {
        $this->building = $value;

        return $this;
    }

    /**
     * @return ArrayBuilder
     */
    public function ary()
    {
        return new ArrayBuilder($this->getSetCallback());
    }

    private function getSetCallback()
    {
        return function($value)
        {
            $this->building = $value;

            return $this;
        };
    }
} 