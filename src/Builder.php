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


interface Builder
{
    /**
     * @return Builder|mixed
     */
    public function end();

    /**
     * @param callable $callback
     *
     * @return $this
     */
    public function setCallback(callable $callback);
} 