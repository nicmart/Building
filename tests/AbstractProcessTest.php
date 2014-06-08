<?php
/**
 * This file is part of library-template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Nicolò Martini <nicmartnic@gmail.com>
 */

namespace NicMart\Building\Test;


use NicMart\Building\AbstractProcess;
use NicMart\Building\Context;

class AbstractProcessTest extends \PHPUnit_Framework_TestCase
{
    /** @var  AbstractProcess */
    protected $process;

    /**
     * @var Context
     */
    protected $context;

    /**
     * @var Context
     */
    protected $contextCopy;

    public function setUp()
    {
        $this->process = $this->getMock('NicMart\Building\AbstractProcess', null);
        $obj = $obj2 = 'foo';
        $this->context = new Context(null, $obj, $this->process);
        $this->contextCopy = new Context(null, $obj2, $this->process);
    }

    public function testBuild()
    {
        $this->assertNull($this->process->build($this->context, 'a', 'b'));

        $this->assertEquals($this->contextCopy, $this->context);
    }

    public function testFinalize()
    {
        $this->process->finalize($this->context);

        $this->assertEquals($this->contextCopy, $this->context);
    }

    public function testSubvalueBuilded()
    {
        $a = 'hello';
        $this->process->subvalueBuilded($this->context, $a);

        $this->assertEquals($this->contextCopy, $this->context);
    }
}
 