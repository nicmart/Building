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

class ScalarProcess extends AbstractProcess
{
    /**
     * {@inheritdoc}
     */
    public function build(Context $context, $value = null)
    {
        $newContext = new Context($context, $value, $this);
        $newContext->notifyParent();

        return null;
    }
} 