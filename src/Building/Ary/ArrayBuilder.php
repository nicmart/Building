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


use Building\AbstractBuilder;
use Building\Context;

class ArrayBuilder extends AbstractBuilder
{
    public function __construct(array &$array = array())
    {
        $this->stack[] = new Context($array, $this, array());

        $this
            ->registerBuilder('node', new NodeBuilder)
            ->registerBuilder('push', new PushBuilder)
        ;
    }

    /**
     * Do initial part of building and return a builder
     *
     * @return AbstractBuilder
     */
    function processStart()
    {
        // TODO: Implement processStart() method.
    }

    /**
     * Do object manipulation using context args.
     *
     * @return mixed
     */
    function processArgs()
    {
        // TODO: Implement processArgs() method.
    }

} 