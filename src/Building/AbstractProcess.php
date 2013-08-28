<?php
/**
 * This file is part of library-template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Nicolò Martini <nicmartnic@gmail.com>
 */

namespace Building;

/**
 * Class AbstractProcess
 * An abstract process that does nothing.
 *
 * @package Building
 */
abstract class AbstractProcess implements BuildProcess
{
    /**
     * {@inheritdoc}
     */
    public function build(Context $context)
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function finalize(Context $context)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function subvalueBuilded(Context $context, $subvalue)
    {
    }

} 