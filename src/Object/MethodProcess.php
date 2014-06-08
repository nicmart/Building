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


use NicMart\Building\AbstractProcess;
use NicMart\Building\Context;

class MethodProcess extends AbstractProcess
{
    public function build(Context $context, $methodName = 'prop', $args = array())
    {
        $newContext = new Context($context, array($methodName, $args), $this);

        if (!$args)
            return $newContext;

        $this->finalize($newContext);

        return null;
    }

    public function subvalueBuilded(Context $context, $subvalue)
    {
        $context->object[1][] = $subvalue;
    }


    /**
     * {@inheritdoc}
     */
    public function finalize(Context $context)
    {
        $context->previous->object->methodCalls[] = $context->object;
    }
}