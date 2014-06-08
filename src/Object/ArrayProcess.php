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

class ArrayProcess extends AbstractProcess
{
    /**
     * {@inheritdoc}
     */
    public function build(Context $context)
    {
        return new Context($context, array(), $this);
    }

    /**
     * {@inheritdoc}
     */
    public function finalize(Context $context)
    {
        $context->notifyParent();
    }
}