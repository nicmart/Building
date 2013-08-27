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


use Building\Ary\NodeProcess;
use Building\Context;
use Building\DummyProcess;

class NodeProcessTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $proc = new NodeProcess();
        $object = array();
        $context = new Context($object, new DummyProcess());

        $resultContext = $proc->build($context, 'key', 'value');
        $this->assertEquals(array('key' => 'value'), $object);
        $this->assertNull($resultContext);

        $object = array();
        $context = new Context($object, $proc);

        $resultContext = $proc->build($context, 'key');

        $this->assertEquals(array('key' => array()), $object);
        $this->assertInstanceOf('Building\Context', $resultContext);
        $this->assertEquals(array(), $resultContext->object);
        $this->assertEquals($proc, $resultContext->process);

        $proc->build($resultContext, 'foo', 'bar');
        $this->assertEquals(array('key' => array('foo' => 'bar')), $object);
    }
}
 