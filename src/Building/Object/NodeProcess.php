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
class NodeProcess extends  AbstractProcess
{
    /**
     * {@inheritdoc}
     */
    public function build(Context $context, $key = 0, $value = null)
    {
        $newContext = new Context($context, array($key, $value), $this);

        if (!isset($value))
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
        list($key, $value) = $context->object;
        $context->previous->object[$key] = $value;
    }
}