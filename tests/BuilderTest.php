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
    /**
     * @var Builder
     */
    protected $builder;

    public function setUp()
    {
    }

    public function testConstructorAndEnd()
    {
        /** @var Builder $builder */
        $builder = $this->getMock('NicMart\\Building\\AbstractBuilder', null, [
            function($x) { return 'foo:' . $x; }, "bar"
        ]);

        $this->assertEquals("foo:bar", $builder->end());
    }

    public function testSetCallback()
    {
        /** @var Builder $builder */
        $builder = $this->getMock('NicMart\\Building\\AbstractBuilder', null, [
            function($x) { return 'foo:' . $x; }, "bar"
        ]);

        $builder->setCallback(function($x) { return 'baz:' . $x; });

        $this->assertEquals("baz:bar", $builder->end());
    }
}