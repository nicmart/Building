<?php
/**
 * This file is part of library-template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Nicolò Martini <nicmartnic@gmail.com>
 */

namespace Building\Ary;


use Building\Builder;
use Building\Context;

class ArrayBuilder extends Builder
{
    public function __construct(array &$array = array())
    {
        parent::__construct(new Context($array));

        $this
            ->registerProcess('node', new NodeProcess)
            ->registerProcess('push', new PushProcess)
        ;
    }
} 