<?php
/*
 * This file is part of Building.
 *
 * (c) 2013 Nicolò Martini
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Building\Test;

use Building\Builder;
use Building\Context;
use Building\DummyProcess;

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
            ->registerProcess('foo', $p1 = $this->getMock('Building\BuildProcess'))
            ->registerProcess('bar', $p2 = $this->getMock('Building\BuildProcess'))
        ;
        $this->assertSame(array('foo' => $p1, 'bar' => $p2), $this->builder->getProcesses());
    }

    public function testContextInConstructor()
    {
        $object = 'ah';
        $builder = new Builder($context = new Context($object, $this->getMock('Building\BuildProcess')));

        $this->assertAttributeSame(array($context), 'stack', $builder);
    }

    public function testBuild()
    {

        $start = 'start';
        $b = new Builder($startContext = new Context($start, new DummyProcess()));

        $p1 = $this->getMock('Building\BuildProcess');
        $p1
            ->expects($this->once())
            ->method('build')
            ->with($this->equalTo($startContext), $this->equalTo('hey'), $this->equalTo('man'))
            ->will($this->returnValue(null));

        $p1
            ->expects($this->once())
            ->method('subvalueBuilded')
            ->with($this->equalTo($secondCContext = new Context($object, $p1)), $this->equalTo('subvalue'));

        $object = 'val';
        $p2 = $this->getMock('\Building\BuildProcess');
        $p2
            ->expects($this->once())
            ->method('build')
            ->will($this->returnValue($secondCContext));

        $p3 = $this->getMock('\Building\BuildProcess');
        $p3
            ->expects($this->once())
            ->method('build')
            ->will($this->returnCallback(function(Context $context) {
                $context->process->subvalueBuilded($context, 'subvalue');
                return null;
            }));

        $b
            ->registerProcess('foo', $p1)
            ->registerProcess('bar', $p2)
            ->registerProcess('baz', $p3)
        ;

        $b->build('foo', array('hey', 'man'));
        $this->assertAttributeSame(array($startContext), 'stack', $b);

        $b->build('bar');
        $this->assertAttributeSame(array($startContext, $secondCContext), 'stack', $b);

        //__call magic call
        $b->baz();
        $this->assertAttributeSame(array($startContext, $secondCContext), 'stack', $b);

        $b->end();
        $this->assertAttributeSame(array($startContext), 'stack', $b);

        $this->assertEquals('start', $b->get());
    }
}