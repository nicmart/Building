<?php
/**
 * This file is part of library-template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Nicolò Martini <nicmartnic@gmail.com>
 */

namespace Building\Test;


use Building\AbstractProcess;
use Building\Context;

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
        $this->process = $this->getMock('Building\AbstractProcess', null);
        $obj = $obj2 = 'foo';
        $this->context = new Context($obj, $this->process);
        $this->contextCopy = new Context($obj2, $this->process);
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
        $this->process->subvalueBuilded($this->context, 'hello');

        $this->assertEquals($this->contextCopy, $this->context);
    }
}
 