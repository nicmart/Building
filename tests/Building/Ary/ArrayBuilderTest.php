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


use Building\Ary\ArrayBuilder;

class ArrayBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testArrayBuilding()
    {
        $b = new ArrayBuilder;

        $procs = $b->getProcesses();

        $this->assertInstanceOf('Building\Ary\NodeProcess', $procs['node']);
        $this->assertInstanceOf('Building\Ary\PushProcess', $procs['push']);
    }
}
 