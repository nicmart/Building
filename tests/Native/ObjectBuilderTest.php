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


use NicMart\Building\Native\ObjectBuilder;

class ObjectBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testArguments()
    {
        $builder = new ObjectBuilder('NicMart\Building\Test\Native\Object');

        $object = $builder
            ->arguments()
                ->push('foo')->push('bar')
            ->end()
        ->end();

        $this->assertEquals(["args" => ['foo', 'bar']], $object->log);
    }

    public function testMethod()
    {
        $builder = new ObjectBuilder('NicMart\Building\Test\Native\Object');

        $object = $builder
            ->arguments()
            ->end()
            ->method('bar', 'v1', 'v2')
            ->method('baz')
                ->push('a')
                ->push()
                    ->push("b")->push("c")
                ->end()
            ->end()
        ->end();

        $this->assertEquals([
            "args" => [],
            "calls" => [
                ["bar", ["v1", "v2"]],
                ["baz", ["a", ["b", "c"]]],
            ]
        ], $object->log);
    }

    public function testProp()
    {
        $builder = new ObjectBuilder('NicMart\Building\Test\Native\Object');

        $object = $builder
            ->arguments()
            ->end()
            ->prop('bar', 'val')
            ->prop('baz')
                ->ary()
                    ->push('a')
                    ->push()
                        ->push("b")->push("c")
                    ->end()
                ->end()
            ->end()
        ->end();

        $this->assertEquals([
            "args" => [],
            "props" => [
                "bar" => "val",
                "baz" => ["a", ["b", "c"]],
            ]
        ], $object->log);
    }
}

class Object
{
    public $log = array();
    public function __construct()
    {
        $this->log['args'] = func_get_args();
    }

    public function __set($name, $value)
    {
        $this->log['props'][$name] = $value;
    }

    public function __call($name, $args)
    {
        $this->log['calls'][] = array($name, $args);
    }
}
 