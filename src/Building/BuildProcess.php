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


interface BuildProcess
{
    /**
     * Take care of the build process.
     * This function accepts an optional list of parameters
     *
     * Returns value semantic:
     * Context: put the new context on the top of the stack
     * null: do nothing
     *
     * @param Context $context
     *
     * @return null|Context
     */
    public function build(Context $context);

    /**
     * Optionally do something on the current scope before leaving it
     *
     * @param Context $context
     * @return mixed
     */
    public function finalize(Context $context);

    /**
     * Get notified when a subvalue has been builded.
     * This is (optionally) called by a builder of a lower level
     *
     * @param Context $context
     * @param mixed $subvalue
     * @return mixed
     */
    public function subvalueBuilded(Context $context, &$subvalue);
} 