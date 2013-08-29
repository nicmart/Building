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


use Building\Builder;
use Building\BuildProcess;
use Building\Context;

class ContextTest extends \PHPUnit_Framework_TestCase
{
    /** @var  BuildProcess */
    protected $process;

    public function setUp()
    {
        $this->process = $this->getMock('Building\BuildProcess');
    }

    public function testConstructor()
    {
        $hello = 'hello';
        $context = new Context(null, $hello, $this->process, 'name');

        $this->assertEquals('hello', $context->object);
        $this->assertEquals($this->process, $context->process);
        $this->assertEquals('name', $context->name);
    }

    public function testObjectIsPassedByReference()
    {
        $hello = 'hello';
        $context = new Context(null, $hello, $this->process);
        $context->object = 'bye';

        $this->assertEquals('bye', $context->object);
    }
}
 