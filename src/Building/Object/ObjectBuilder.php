<?php
/**
 * This file is part of library-template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Nicolò Martini <nicmartnic@gmail.com>
 */

namespace Building\Object;


use Building\Builder;
use Building\Context;

class ObjectBuilder extends Builder
{
    public function __construct($className)
    {
        $this
            ->registerProcess('value', new ScalarProcess)
            ->registerProcess('array', new ArrayProcess)
            ->registerProcess('object', $objectProc = new ObjectProcess)
            ->registerProcess('method', new MethodProcess())
            ->registerProcess('prop', new PropertyProcess)
            ->registerProcess('arguments', new ArgumentsProcess)
        ;

        parent::__construct(new Context(new ObjectDefinition($className), $objectProc, 'object'));
    }
} 