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


use NicMart\Building\Native\ValueBuilder;

class ValueBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testSet()
    {
        $builder = new ValueBuilder;

        $builder->set('foo');

        $this->assertEquals('foo', $builder->end());
    }

    public function testAry()
    {
        $builder = new ValueBuilder;

        $ary = $builder
            ->ary()
                ->push('a')
                ->push('b')
                ->set('foo')
                    ->push('bar')
                    ->push('baz')
                ->end()
            ->end()
        ->end();

        $this->assertSame(['a', 'b', 'foo' => ['bar', 'baz']], $ary);
    }
}
 