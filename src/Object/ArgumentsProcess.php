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

class ArgumentsProcess extends AbstractProcess
{
    public function build(Context $context)
    {
        return new Context($context, array(), $this);
    }

    public function subvalueBuilded(Context $context, $subvalue)
    {
        $context->object[] = $subvalue;
    }

    public function finalize(Context $context)
    {
        $context->previous->object->arguments[] = $context->object;
    }
}