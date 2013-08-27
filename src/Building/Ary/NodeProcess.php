<?php
/**
 * This file is part of library-template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Nicolò Martini <nicmartnic@gmail.com>
 */

namespace Building\Ary;

use Building\BuildProcess;
use Building\Context;

/**
 * Class NodeProcess
 * An simple example of a builder for arrays. Go to the examples directory to see it working.
 *
 * @package Building
 */
class NodeProcess implements BuildProcess
{
    /**
     * {@inheritdoc}
     */
    public function build(Context $context, $key = 0, $value = null)
    {
        $buildValue = isset($value) ? $value : array();

        $context->object[$key] = &$buildValue;

        return !isset($value)
            ? new Context($buildValue, $this)
            : null;
    }

    /**
     * {@inheritdoc}
     */
    public function subvalueBuilded(Context $context, $subvalue)
    {
        // Do nothing
    }
}