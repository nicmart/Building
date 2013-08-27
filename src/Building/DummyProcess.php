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
 * Class DummyProcess
 *
 * Empty process used to bootstrap the builders context.
 *
 * @package Building
 */
class DummyProcess implements BuildProcess
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
    public function subvalueBuilded($subvalue)
    {
        //Do nothing
    }

} 