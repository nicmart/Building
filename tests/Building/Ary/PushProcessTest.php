<?php
/**
 * This file is part of library-template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Nicolò Martini <nicmartnic@gmail.com>
 */

namespace Building\Test\Ary;


use Building\Ary\PushProcess;
use Building\Context;
use Building\DummyProcess;

class PushProcessTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $proc = new PushProcess();
        $object = array();
        $context = new Context($object, new DummyProcess());

        $resultContext = $proc->build($context, 'value');
        $this->assertEquals(array('value'), $object);
        $this->assertNull($resultContext);

        $object = array();
        $context = new Context($object, $proc);

        $resultContext = $proc->build($context);

        $this->assertEquals(array(array()), $object);
        $this->assertInstanceOf('Building\Context', $resultContext);
        $this->assertEquals(array(), $resultContext->object);
        $this->assertEquals($proc, $resultContext->process);

        $proc->build($resultContext, 'foo');
        $this->assertEquals(array(array('foo')), $object);
    }
}
