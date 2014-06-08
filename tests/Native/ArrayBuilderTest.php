<?php
/**
 * This file is part of library-template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Nicolò Martini <nicmartnic@gmail.com>
 */

namespace NicMart\Building\Test\Native;


use NicMart\Building\Native\ArrayBuilder;
use NicMart\Building\Native\ValueBuilder;

class ArrayBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testPush()
    {
        $builder = new ArrayBuilder;

        $ary = $builder
            ->push('foo')->push('bar')
        ->end();

        $this->assertSame(['foo', 'bar'], $ary);
    }

    public function testPushScope()
    {
        $builder = new ArrayBuilder;

        $ary = $builder
            ->push()
                ->set("foo")
            ->end()
        ->end();

        $this->assertSame(["foo"], $ary);
    }

    public function testSet()
    {
        $builder = new ArrayBuilder;

        $ary = $builder
            ->set('foo', 'fooval')->set('bar', 'barval')
        ->end();

        $this->assertSame(['foo' => 'fooval', 'bar' => 'barval'], $ary);
    }

    public function testSetScope()
    {
        $builder = new ArrayBuilder;

        $ary = $builder
            ->set('foo')
                ->set("fooval")
            ->end()
        ->end();

        $this->assertSame(["foo" => "fooval"], $ary);
    }
}
