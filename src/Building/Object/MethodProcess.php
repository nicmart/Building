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


use Building\AbstractProcess;
use Building\Context;

class MethodProcess extends AbstractProcess
{
    public function build(Context $context, $methodName = 'prop', $args = array())
    {
        $context->object->methodCalls[] = array($methodName, &$args);

        if (!($args))
            return new Context($args, $this);

        return null;
    }

    public function subvalueBuilded(Context $context, &$subvalue)
    {
        $context->object[] = $subvalue;
    }
}