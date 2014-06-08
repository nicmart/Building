<?php
/**
 * This file is part of library-template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Nicolò Martini <nicmartnic@gmail.com>
 */

namespace NicMart\Building\Object;


use NicMart\Building\Builder;
use NicMart\Building\Context;

class ArrayBuilder extends Builder
{
    public function __construct(array &$array = array())
    {
        $this
            ->registerProcess('array', $aryProcess = new ArrayProcess)
            ->registerProcess('value', new ScalarProcess)
            ->registerProcess('node', new NodeProcess)
            ->registerProcess('push', new PushProcess)
        ;

        parent::__construct(new Context(null, $array, $aryProcess));
    }
} 