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

class PropertyProcess extends AbstractProcess
{
    public function build(Context $context, $propName = 'prop', $propValue = null)
    {
        $newContext = new Context($context, array($propName, $propValue), $this);

        if (!isset($propValue))
            return $newContext;

        $this->finalize($newContext);

        return null;
    }

    public function subvalueBuilded(Context $context, $subvalue)
    {
        $context->object[1] = $subvalue;
    }

    public function finalize(Context $context)
    {
        $objDef = $context->previous->object;
        list($propName, $propValue) = $context->object;
        $objDef->propertiesSet[$propName] = $propValue;
    }
}