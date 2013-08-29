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

/**
 * Class NodeProcess
 * An simple example of a builder for arrays. Go to the examples directory to see it working.
 *
 * @package Building
 */
class PushProcess extends  AbstractProcess
{
    /**
     * {@inheritdoc}
     */
    public function build(Context $context, $value = null)
    {
        $newContext = new Context($context, $value, $this);

        if (!isset($value))
            return $newContext;

        $this->finalize($newContext);

        return null;
    }

    public function subvalueBuilded(Context $context, $subvalue)
    {
        $context->object = $subvalue;
    }

    /**
     * {@inheritdoc}
     */
    public function finalize(Context $context)
    {
        $context->previous->object[] = $context->object;
    }
}