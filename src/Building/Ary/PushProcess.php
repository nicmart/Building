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

use Building\Builder;
use Building\BuildProcess;
use Building\Context;

/**
 * Class PushProcess
 *
 * @package Building
 */
class PushProcess implements BuildProcess
{
    /**
     * {@inheritdoc}
     */
    public function build(Context $context, $value = null)
    {
        $buildValue = isset($value) ? $value : array();
        $context->object[] = &$buildValue;

        return !isset($value)
            ? new Context($buildValue, $this)
            : null
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function subvalueBuilded(Context $context, $subvalue)
    {
        // Do nothing
    }
}