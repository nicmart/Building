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

class ObjectProcess extends AbstractProcess
{
    /**
     * @param Context $context
     * @param string $className
     * @return Context|null
     */
    public function build(Context $context, $className = 'stdClass')
    {
        return new Context($context, new ObjectDefinition($className), $this);
    }

    /**
     * {@inheritdoc}
     */
    public function finalize(Context $context)
    {
        $context->notifyParent();
    }
}