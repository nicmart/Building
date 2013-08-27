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

use Building\AbstractBuilder;
use Building\Context;

/**
 * Class ArrayBuilder
 * An simple example of a builder for arrays. Go to the examples directory to see it working.
 *
 * @package Building
 */
class NodeBuilder extends AbstractBuilder
{
    /**
     * {@inheritdoc}
     */
    function processStart($key = 0, $value = null)
    {
        if (isset($value)) {
            $this->context()->object[$key] = $value;
        } else {
            $value = array();
            $this->context()->object[$key] = &$value;
            $this->stack[] = new Context(
                $value, $this,  array()
            );
        }

        return $this->context()->builder;
    }

    /**
     * {@inheritdoc}
     */
    function processArgs()
    {
        // TODO: Implement processArgs() method.
    }

} 