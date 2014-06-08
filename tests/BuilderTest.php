<?php
/*
 * This file is part of Building.
 *
 * (c) 2013 Nicolò Martini
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NicMart\Building\Test;

use NicMart\Building\Builder;
use NicMart\Building\Context;
use NicMart\Building\DummyProcess;

/**
 * Unit tests for class FirstClass
 */
class BuilderTest extends \PHPUnit_Framework_TestCase
{
    /** @var  Builder */
    protected $builder;
    protected $processThatPushContext;
    protected $processThatDoesNotPush;
    protected $processThatDowsNotPush;

    public function setUp()
    {
        $this->builder = new Builder;

    }

    public function testRegisterProcessAndGetProcesses()
    {
        $this->builder
            ->registerProcess('foo', $p1 = $this->getMock('NicMart\Building\BuildProcess'))
            ->registerProcess('bar', $p2 = $this->getMock('NicMart\Building\BuildProcess'))
        ;
        $this->assertSame(array('foo' => $p1, 'bar' => $p2), $this->builder->getProcesses());
    }

    public function testContextInConstructor()
    {
        $object = 'ah';
        $builder = new Builder($context = new Context(null, $object, $this->getMock('NicMart\Building\BuildProcess')));

        $this->assertAttributeSame($context, 'context', $builder);
    }

    public function testBuild()
    {

        $start = 'start';
        $b = new Builder($startContext = new Context(null, $start, new DummyProcess()));

        $p1 = $this->getMock('NicMart\Building\BuildProcess');
        $p1
            ->expects($this->once())
            ->method('build')
            ->with($this->equalTo($startContext), $this->equalTo('hey'), $this->equalTo('man'))
            ->will($this->returnValue(null));

        $p1
            ->expects($this->once())
            ->method('subvalueBuilded')
            ->with($this->equalTo($secondCContext = new Context($startContext, 'ah', $p1)), $this->equalTo('subvalue'));
        $p1
            ->expects($this->once())
            ->method('finalize')
            ->with($this->equalTo($secondCContext));

        $p2 = $this->getMock('\NicMart\Building\BuildProcess');
        $p2
            ->expects($this->once())
            ->method('build')
            ->will($this->returnValue($secondCContext));

        $subvalue = 'subvalue';
        $p3 = $this->getMock('\NicMart\Building\BuildProcess');
        $p3
            ->expects($this->once())
            ->method('build')
            ->will($this->returnCallback(function(Context $context) use (&$subvalue) {
                $context->process->subvalueBuilded($context, $subvalue);
                return null;
            }));

        $b
            ->registerProcess('foo', $p1)
            ->registerProcess('bar', $p2)
            ->registerProcess('baz', $p3)
        ;

        $b->build('foo', array('hey', 'man'));
        $this->assertAttributeSame($startContext, 'context', $b);
        $this->assertEquals('foo', $startContext->name);

        $b->build('bar');
        $this->assertAttributeSame($secondCContext, 'context', $b);

        //__call magic call
        $b->baz();
        $this->assertAttributeEquals($secondCContext, 'context', $b);

        $b->end();
        $this->assertAttributeEquals($startContext, 'context', $b);

        $this->assertEquals('start', $b->get());
    }
}