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

class PropertyProcess extends AbstractProcess
{
    public function build(Context $context, $propName = 'prop', $propValue = null)
    {
        $context->object->propertiesSet[$propName] = $propValue;

        if (!isset($propValue))
            return new Context($context->object->propertiesSet[$propName], $this);

        return null;
    }

    public function subvalueBuilded(Context $context, &$subvalue)
    {
        $context->object = $subvalue;
    }
}